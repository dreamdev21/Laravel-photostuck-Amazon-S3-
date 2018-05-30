<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'code',
    ];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public static function createFromUser($user){
      return Activation::create([
        'user_id' => $user->id,
        'code' => str_random(32),
      ]);
    }

    public static function complete($user, $activation_code){
      $activation = Activation::where('code', $activation_code)->first();
      if($activation){
        $activation->completed = 1;
        $activation->save();
        $user->activated = 1;
        $user->save();
        return true;
      }
      return false; // not completed
    }
}
