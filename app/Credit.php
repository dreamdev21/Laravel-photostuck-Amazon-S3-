<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subscription;

class Credit extends Model
{
  public $timestamps = false;
  protected $fillable = [
      'current_credit', 'last_subscription_id', 'consumed_credit', 'user_id', 'total_downloads'
  ];
  public function user(){
    return $this->belongsTo('App\User');
  }

}
