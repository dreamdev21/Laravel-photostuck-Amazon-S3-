<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'city'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activations(){
      return $this->hasMany('App\Activation');
    }

    public function contributors(){
      return $this->hasMany('App\Contributor');
    }

    public function contributor(){
      return \App\Contributor::where('user_id', $this->id)->first();
    }

    public function artworks(){
      return $this->hasMany('App\Artwork');
    }

    /*public function customers(){
      return $this->hasMany('App\Customer');
    }
    public function customer(){
      return \App\Customer::where('user_id', $this->id)->first();
    }*/

    public function credit(){
      return $this->hasOne('App\Credit');
    }

    public function isContributor() {
      return $this->hasRole('contributor');
    }

    public function hasContributorRecord(){
      return \Auth::user()->contributors()->get()->isNotEmpty();
    }
    public function subscriptions(){
      return $this->hasMany('App\Subscription');
    }

    public function downloads(){
      return $this->hasMany('App\Download');
    }

    public function addCredit($amount){
      return $this->credit->current_credit =+ $amount;
      //return $this->save();
    }

    public function intiateCreditRecord($sub){
      return Credit::create([
          'current_credit' => $sub->package->credit,
          'last_subscription_id' => $sub->id,
          'consumed_credit' => 0,
          'total_downloads' => 0,
          'user_id' => $sub->user_id,
      ]);
    }

    public function artworkExists($id){
      $count= Download::where('user_id' , $this->id)->where('artwork_id', $id)->count();
      if($count>0){
        return true;
      }
      return false;
    }
}
