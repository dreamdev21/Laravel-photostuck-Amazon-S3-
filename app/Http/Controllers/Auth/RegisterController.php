<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Activation;
use App\Notifications\AccountToBeConfirmed;
use App\Notifications\AccountConfirmed;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request){
      $this->validate($request, [
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6|confirmed',
      ]);

      $user = $this->create($request->all());
      $activation = Activation::createFromUser($user);
      $user->notify(new AccountToBeConfirmed($activation->code));
      return redirect('/login')->with(['success' => 'Please check your email inbox to confirm your email.']);
    }

    public function activate($email, $activationCode){
      $user = User::whereEmail($email)->first();
      if(Activation::complete($user, $activationCode)){
        $user->notify(new AccountConfirmed());
        return redirect('/login')->with(['success' => 'Account is activated successfully.']);
      }
      return redirect('/login')->with(['error' => 'Account could not be activated.']);
    }
}
