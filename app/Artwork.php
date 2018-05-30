<?php

namespace App;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Artwork extends Model
{
  use Searchable;
  use Sluggable;

  protected $fillable = [
      'name', 'taken_at', 'taken_in', 'tags', 'description', 'category_id', 'tags'
  ];

  public function sluggable()
  {
      return [
          'slug' => [
              'source' => 'name'
          ]
      ];
  }

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function categories(){
    return $this->belongsToMany('App\Category');
  }

  public function downloads(){
    return $this->hasMany('App\Download');
  }

  public function contributor(){
    return $this->belongsTo('App\Contributor');
  }

  public function original_url(){
    return $this->signed_url();
    //return Storage::disk('s3')->url($this->filepath, '+5 minutes');
  }

  public function signed_url(){
    $adapter = Storage::disk('s3')->getDriver()->getAdapter();
    $command = $adapter->getClient()->getCommand('GetObject', [
        'Bucket' => $adapter->getBucket(),
        'Key'    => $adapter->getPathPrefix(). $this->filepath
    ]);
    $request = $adapter->getClient()->createPresignedRequest($command, '+1 minute');
    return (string) $request->getUri();
  }

  public function thumb_url(){
    return Storage::disk('s3')->url($this->thumbpath);
  }
  public function medium_url(){
    return Storage::disk('s3')->url($this->mediumpath);
  }


  public function setTagsAttribute($value){
      if(is_array($value)){
        $this->attributes['tags'] = implode(",", $value);
      }else{
        $this->attributes['tags'] = $value;
      }
  }

  public function getTagsAttribute($value){
    $result = explode(',', $value);
    $tags = collect($result);
    return $tags;
  }

  public function getFilesizeAttribute($value){
    return (double)$value/1000;
  }

  public function statusDesc(){
    if($this->status == \Config::get('constants.artwork_status.PENDING')){
      return trans('auth.pending');
    }elseif($this->status == \Config::get('constants.artwork_status.REJECTED')){
      return trans('auth.rejected');
    }elseif($this->status == \Config::get('constants.artwork_status.APPROVED')){
      return trans('auth.approved');
    }else{
      return trans('auth.unknown');
    }
  }

}
