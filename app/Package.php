<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
  public function subscriptions(){
    return $this->hasMany('App\Subscription');
  }

  public function isUnlimited(){
    if($this->validity == 0){
      return true;
    }
    return false;
  }

  public function price_per_image(){
    if($this->price != 0 && $this->credit !=0){
      return number_format($this->price / $this->credit, 2, '.', ',');
    }
  }

  public static function lowestSinglePrice(){
      return Package::where('credit', 1)->first()->price;
  }
  public static function lowestMultiplePrice(){
    $lowestPricePackage = Package::orderBy('credit', 'desc')->first();
    return number_format($lowestPricePackage->price / $lowestPricePackage->credit, 0,'.',',');
  }
}
