<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
  public $timestamps = false;
  protected $fillable = [
      'artwork_id', 'user_id', 'downloaded_at', 'browser', 'ip_address', 'credit_before', 'credit_after',
  ];

  public function artwork(){
    return $this->belongsTo('App\Artwork');
  }

  public function customer(){
    return $this->belongsTo('App\Customer');
  }

  public function contributor(){
    return $this->belongsTo('App\Contributor');
  }

  public function user(){
    return $this->belongsTo('App\User');
  }

}
