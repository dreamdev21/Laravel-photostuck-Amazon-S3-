<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
  protected $fillable = ['package_id', 'user_id', 'expiry_date', 'status', 'payment_method', 'payment_date', 'payment_reference','payment_amount'];

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function package(){
    return $this->belongsTo('App\Package');
  }
}
