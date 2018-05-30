<?php

namespace App\Http\Controllers;

use App\Artwork;
use Illuminate\Http\Request;
use Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\User;
use Carbon\Carbon;
use App\Category;
use Session;
use Auth;
use App\Download;
use App\Notifications\NewArtworksUploaded;
use App\Notifications\ArtworkStatusUpdated;

use DB;

class ArtworkController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
      if(Auth::user()->can('admin')){
        $artworks = Artwork::orderBy('created_at', 'desc')->get();
      }else{
        $artworks = Artwork::where('status',1)->orderBy('created_at', 'desc')->get();
      }
      return view('artworks.index', compact('artworks'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
      return view('artworks.create-step-1');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function store(Request $request)
  {
      /*$this->validate($request, [
        'files.*' => 'dimensions:min_width=300,max_width=2000,min_height=300,min_height=2000|dimensions:ratio=1/1|mimes:jpeg,jpg'
      ]);*/

      $user = \Auth::user();

      $artworks = collect(new Artwork);
      $all_files = $request->file('files');
      if($all_files){
        foreach ($all_files as $file) {
          // uploading to s3
          $cloud_result = $this->uploadArtworkToCloud($user, $file);
          /*$labels = \Rekognition::detectLabels([
            'Image' => [
                'S3Object' => [
                    'Bucket' => env('S3_BUCKET'),
                    'Name' => $cloud_result['thumbpath'],
                ],
            ],
            'MaxLabels' => 5,
            'MinConfidence' => 75,
          */

          $db_result = $this->saveArtworkToDB($user, $file, $cloud_result);
          $artworks->push($db_result);
        }
      }
      $user->notify(new NewArtworksUploaded());
      \Session::flash('flash_message', trans('messages.artworks_first_step'));
      $categories = Category::all();
      return view('artworks.create-step-2', compact('artworks', 'categories'));
  }

  public function tryUpload(Request $request){
    return response()->json([
      ['code'=> 200, 'message' => 'Good']
    ]);
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
  public function show($id)
  {
      $artwork = Artwork::findOrFail($id);
      $artwork->lowestSinglePrice = \App\Package::lowestSinglePrice();
      $artwork->lowestMultiplePrice = \App\Package::lowestMultiplePrice();
      return view('artworks.show', compact('artwork'));
  }

  public function view($slug)
  {
      $artwork = Artwork::where('slug', $slug)->first();
      $artwork->lowestSinglePrice = \App\Package::lowestSinglePrice();
      $artwork->lowestMultiplePrice = \App\Package::lowestMultiplePrice();
      return view('artworks.show', compact('artwork'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
  public function edit($id)
  {
      $artwork = Artwork::findOrFail($id);
      $categories = Category::all();
      return view('artworks.edit', compact('artwork', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function update(Request $request)
  {
      $artwork = Artwork::findOrFail($request->id);
      $artwork->update($request->all());
      \Session::flash('flash_message', trans('messages.updated_successfully'));
      return redirect('dashboard');
  }

  public function updateBatch(Request $request){
    // set index to number of records submitted (-1 to iterate in the array)
    $index= count($request->id) -1;
    // get all the data from request to new object
    //$allFilesInfo = $request->all();
    while($index >= 0) {
      $artwork = Artwork::find($request->id[$index]);
      $artwork->name = $request->name[$index];
      $artwork->tags = $request->tags[$index];
      $artwork->description = $request->description[$index];
      $artwork->taken_at = $request->taken_at[$index];
      $artwork->taken_in = $request->taken_in[$index];
      $artwork->category_id = $request->category_id[$index];
      $artwork->save();
      $index--;
    }
    \Session::flash('success', trans('messages.successfully_uploaded'));
    return redirect()->action('DashboardController@index');
  }

  public function download($id){
      $artwork = Artwork::find($id);
      header("Cache-Control: public");
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=" . $artwork->filename);
      header("Content-Type: " . 'image/jpg');

      return readfile($artwork->original_url());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function destroy($id)
  {
      $artwork = Artwork::findOrFail($id);
      $done = Storage::disk('s3')->delete($artwork->filepath);
      //if($done){
        Artwork::destroy($id);
      //}
      \Session::flash('flash_message', trans('messages.deleted_successfully'));
      return redirect('dashboard');
  }

  // additional functions
  private function uploadArtworkToCloud(User $user, UploadedFile $file){
    $image_file = Image::make($file)->encode('jpg');

    // prepare the files names for 3 versions (original, thumb, medium)
    $image_file_name = 'artworks'. '/'. $user->id. '/Yohka_'. time() . '.'. $file->getClientOriginalExtension();
    $medium_file_name = 'artworks'. '/'. $user->id. '/Yohka_'. time() . '_medium.'. $file->getClientOriginalExtension();
    $thumb_file_name = 'artworks'. '/'. $user->id. '/Yohka_'. time() . 'thumb.'. $file->getClientOriginalExtension();

    // store the original file in s3 with private access
    $filepath = Storage::disk('s3')->put($image_file_name, $image_file->__toString() );

    // prepare the medium version and store to s3 - added watermark to the image
    $watermark = Image::make(public_path('/img/watermark.png'))->opacity(30);;
    $medium_image = Image::make($file)->orientate()
                                ->fit(800, 800)->insert($watermark, 'center')
                                ->encode('jpg');
    $medium_filepath = Storage::disk('s3')->put( $medium_file_name, $medium_image->__toString() , 'public');

    // prepare the thumn version and store to s3
    $thumb_image = Image::make($file)->orientate()
                                ->fit(250, 250)
                                ->encode('jpg');
    $thumb_filepath = Storage::disk('s3')->put( $thumb_file_name, $thumb_image->__toString() , 'public');

    $result = [
      'filepath' => $image_file_name,
      'mediumpath' => $medium_file_name,
      'thumbpath' => $thumb_file_name,
    ];
    return $result;
  }

  private function saveArtworkToDB(User $user, UploadedFile $file, $filepaths){
    $image = Image::make($file);
    $image_metadata = $image->exif();
//    var_dump($image);exit;
    $oneArtwork = new Artwork();
    $oneArtwork->filepath = $filepaths['filepath'];
    $oneArtwork->mediumpath = $filepaths['mediumpath'];
    $oneArtwork->thumbpath = $filepaths['thumbpath'];
    $oneArtwork->filename = $file->getClientOriginalName();
    $oneArtwork->name = $file->getClientOriginalName();
    $oneArtwork->mimetype = $image_metadata['MimeType'];
    $oneArtwork->filesize = $image_metadata['FileSize'];
    if(array_key_exists('DateTime',$image_metadata)){
      $oneArtwork->taken_at = $this->changeFormat($image_metadata['DateTime']);
    }
    if(array_key_exists('SectionsFound',$image_metadata)){
      $oneArtwork->tags = $image_metadata['SectionsFound'];
    }
    $oneArtwork->created_at = Carbon::now();
    $oneArtwork->contributor_id = $user->contributor()->id;
    $oneArtwork->save();
    return $oneArtwork;
  }

  public function changeFormat($string){
    $splitDate = explode(' ', $string, 2);
    $splitDate[0] = str_replace(':', '-', $splitDate[0]);
    $result = $splitDate[0].' '.$splitDate[1];
    return $result;
  }

  public function approve($id){
      $artwork = Artwork::findOrFail($id);
      $artwork->status = 1;
      $artwork->save();
      $artwork->contributor->user->notify(new ArtworkStatusUpdated($artwork));
      \Session::flash('success', trans('messages.artwork_approved'));
      return redirect('artworks');
  }
  public function reject($id){
    $artwork = Artwork::findOrFail($id);
    $artwork->status = 2;
    $artwork->save();
    $artwork->contributor->user->notify(new ArtworkStatusUpdated($artwork));
    \Session::flash('success', trans('messages.artwork_rejected'));
    return redirect('artworks');
  }
  public function hold($id){
    $artwork = Artwork::findOrFail($id);
    $artwork->status = 0;
    $artwork->save();
    $artwork->contributor->user->notify(new ArtworkStatusUpdated($artwork));
    \Session::flash('success', trans('messages.artwork_pending'));
    return redirect('artworks');
  }

  /**
   * The main function that customer purchases the asset.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function addToMyDownloads($id){
    $user = Auth::user();
    $artwork = Artwork::findOrFail($id);
    DB::beginTransaction();
    try {
        $credit_before = $user->credit->current_credit;
        // deduct the credit for customer
        $user->credit->current_credit = $user->credit->current_credit - 1;
        $user->credit->save();
        // increase balance for contributor
        $artwork->contributor->balance = $artwork->contributor->balance + 1;
        $artwork->contributor->save();
        // create the download transaction
        $download = Download::create([
          'artwork_id' => $artwork->id,
          'user_id' => $user->id,
          'downloaded_at' => Carbon::now(),
          'browser' => '',
          'ip_address' => '',
          'credit_before' => $credit_before,
          'credit_after' => $user->credit->current_credit,
        ]);

        DB::commit();
        Session::flash('success', trans('messages.added_to_mydownloads'));
        return redirect()->back();
     }
     catch (Exception $e) {
         DB::rollback();
         Session::flash('error', trans('messages.failed_ops'));
         return redirect()->back();
     }
  }
}
