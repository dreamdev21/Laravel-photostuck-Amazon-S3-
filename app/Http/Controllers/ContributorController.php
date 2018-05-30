<?php

namespace App\Http\Controllers;

use App\Contributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Notifications\ContributorStatusUpdated;
class ContributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $contributors = Contributor::all();
        return view('contributors.index', compact('contributors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(\Auth::user()->can('contributor') || \Auth::user()->hasContributorRecord()){
          return view('contributors.dashboard');
        }
        return view('contributors.create');
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
        //dd($request->all());
        $this->validate($request, [
          'address' => 'required',
          'document' => 'required',
          'bio' => 'required',
        ]);

        $user = \Auth::user();
        $cont = new Contributor();
        $cont->user_id = $user->id;
        $cont->address = $request->address;
        $cont->bio = $request->bio;

        if($request->hasFile('document')){
          $doc_file = $request->file('document');
          $doc_file_name = time() . '_' . $user->id .'.'. $doc_file->getClientOriginalExtension();
          $doc_file->storeAs('docs/', $doc_file_name, 'public');
          $cont->document = $doc_file_name;
        }

        if($request->hasFile('avatar')){
          $avatar_file = $request->file('avatar');
          $avatar_file_name = time() . '_' . $user->id .'.'. $avatar_file->getClientOriginalExtension();
          $avatar_file->storeAs('avatar/', $avatar_file_name, 'public');
          $cont->avatar = $avatar_file_name;
        }
        $cont->save();

        // assign role to the user
        $user->role = \Config::get('constants.roles.CONTRIBUTOR');
        $user->save();
        \Session::flash('warning', trans('messages.contributor_added_successfully'));
        return redirect('home');
    }

    // depricated, now we apply direct download from file directory
    public function downloadDocument($id){
      //$the_file = Storage::disk('public')->url('docs/'.Contributor::find($id)->document);
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
        $contributor = Contributor::findOrFail($id);
        $artworks = $contributor->artworks->where('status', \Config::get('constants.artwork_status.APPROVED'));
        return view('contributors.show', compact('contributor', 'artworks'));
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
        $contributor = Contributor::findOrFail($id);
        return view('contributors.edit', compact('contributor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $contributor = Contributor::findOrFail($id);
        $contributor->update($request->all());
        \Session::flash('flash_message', trans('messages.updated_successfully'));
        return redirect('contributors');
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
        //Contributor::destroy($id);
        //Session::flash('flash_message', trans('messages.deleted_successfully'));
        \Session::flash('success', 'NOT IMPLEMENTED');
        return redirect('contributors');
    }

    public function approve($id){
        $contributor = Contributor::findOrFail($id);
        $contributor->status = \Config::get('constants.contributor_status.APPROVED');
;
        $contributor->save();
        $contributor->user->notify(new ContributorStatusUpdated($contributor));
        \Session::flash('success', trans('messages.contributor_approved'));
        return redirect('contributors');
    }
    public function reject($id){
        $contributor = Contributor::findOrFail($id);
        $contributor->status = \Config::get('constants.contributor_status.REJECTED');
        $contributor->save();
        $contributor->user->notify(new ContributorStatusUpdated($contributor));
        \Session::flash('success', trans('messages.contributor_rejected'));
        return redirect('contributors');
    }
    public function switchToPending($id){
        $contributor = Contributor::findOrFail($id);
        $contributor->status = \Config::get('constants.contributor_status.PENDING');
        $contributor->save();
        $contributor->user->notify(new ContributorStatusUpdated($contributor));
        \Session::flash('success', trans('messages.contributor_pending'));
        return redirect('contributors');
    }



}
