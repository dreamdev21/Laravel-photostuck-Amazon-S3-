<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Customer;
use App\Package;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\User;
use App\Activation;
use App\Notifications\AccountToBeConfirmed;
use App\Notifications\CreditRecharged;
use App\Subscription;
use Carbon\Carbon;

class CustomersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
      //$customers = Customer::paginate($perPage);
      $customers = Customer::all();
      dd('customers');

      return view('customers.index', compact('customers'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
      return view('customers.create');
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
      Customer::create($request->all());
      Session::flash('flash_message', trans('messages.added_successfully'));
      return redirect('customers');
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
      $customer = Customer::findOrFail($id);
      return view('customers.show', compact('customer'));
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
      $customer = Customer::findOrFail($id);
      return view('customers.edit', compact('customer'));
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
      $customer = Customer::findOrFail($id);
      $customer->update($request->all());
      Session::flash('flash_message', trans('messages.updated_successfully'));
      return redirect('customers');
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
      Customer::destroy($id);
      Session::flash('flash_message', trans('messages.deleted_successfully'));
      return redirect('customers');
  }

  public function subscribe($option){
    $packages = Package::orderBy('price', 'desc')->get();
    return view('customers.subscribe', compact('packages'));
  }

  public function checkout($package){
    $package = Package::findOrFail($package);
    if(Auth::check()){
      $user = Auth::user();
    }else{
      $user = new User();
    }
    return view('customers.checkout', compact('package', 'user'));
  }

  public function postCheckout(Request $request){
    //dd($request->all());
    /**** step1: ****/
    //create user if not already existing
    $this->validate($request,[
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255',
      'mobile' => 'required|digits:10',
      'city' => 'required',
    ]);

    if(\Auth::check()){
      $user = \Auth::user();
    }else{
      // notify user with new account created
      $user = $this->createUser($request->all());
      $activation = Activation::createFromUser($user);
      $user->notify(new AccountToBeConfirmed($activation->code));
    }

    /**** step2: ****/
    // create order
    $subscription = $this->createSubscription($request->all(), $user->id);
    // noify user with new order placed
    $user->notify(new CreditRecharged($subscription));

    /**** step3: ****/
    // if online payment selected create pay page
    // redirect user to Paytabs

    Session::flash('success', trans('messages.subscription_created'));
    return view('customers.checkout-message', compact('subscription'));
  }

  protected function createUser(array $data)
  {
      return User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'mobile' => $data['mobile'],
          'city' => $data['city'],
          'password' => bcrypt('123456'),
      ]);
  }

  protected function createSubscription(array $data, $user_id)
  {
      $pckg = Package::findOrFail($data['package_id']);

      return Subscription::create([
          'package_id' => $data['package_id'],
          'user_id' => $user_id,
          'expiry_date' => Carbon::now()->addDays($pckg->validity),
          'status' => \Config::get('constants.subscription_status.PENDING'),
          'payment_method' => $data['payment_method'],
          'payment_date' => null,
          'payment_reference' => null,
          'payment_amount' => $pckg->price,
      ]);
  }
}
