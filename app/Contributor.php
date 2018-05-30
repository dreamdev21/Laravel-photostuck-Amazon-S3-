<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'address','bio', 'document', 'avatar', 'user_id',
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function downloads(){
    return $this->hasMany('App\Download');
  }

  public function artworks(){
    return $this->hasMany('App\Artwork');
  }

  public function statusDesc(){
    if($this->status == \Config::get('constants.contributor_status.PENDING')){
      return trans('auth.pending');
    }elseif($this->status == \Config::get('constants.contributor_status.REJECTED')){
      return trans('auth.rejected');
    }elseif($this->status == \Config::get('constants.contributor_status.APPROVED')){
      return trans('auth.approved');
    }else{
      return trans('auth.unknown');
    }
  }
}
