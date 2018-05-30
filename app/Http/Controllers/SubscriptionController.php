<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use Session;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderPaid;
use App\Notifications\CreditRecharged;

class SubscriptionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
      $subscriptions = Subscription::orderBy('id', 'asc')->get();
      return view('subscriptions.index', compact('subscriptions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
      return view('subscriptions.create');
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
      $sub = Subscription::create($request->all());
      \Auth::user()->notify(new OrderPlaced($sub));
      Session::flash('flash_message', trans('messages.added_successfully'));
      return redirect('subscriptions');
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
      $subscription = Subscription::findOrFail($id);
      return view('subscriptions.show', compact('subscription'));
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
      $subscription = Subscription::findOrFail($id);
      return view('subscriptions.edit', compact('subscription'));
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
      $subscription = Subscription::findOrFail($id);
      $subscription->update($request->all());
      Session::flash('flash_message', trans('messages.updated_successfully'));
      return redirect('subscriptions');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function markAsPaid($id)
  {
      $sub = Subscription::findOrFail($id);
      // change subscription status to paid
      $sub->status = \Config::get('constants.subscription_status.PAID');

      // add credit to the user
      if($sub->user->credit){
        $sub->user->credit->current_credit =  $sub->user->credit->current_credit + $sub->package->credit;
      }else{
        $sub->user->intiateCreditRecord($sub);
      }
      $sub->save();

      // notify
      $sub->user->notify(new CreditRecharged($sub));

      // logging
      Session::flash('flash_message', trans('messages.marked_as_paid_successfully'));
      return redirect()->back();
  }

  public function cancel($id)
  {
      // change subscription status to pending
      $sub = Subscription::findOrFail($id);
      // change subscription status to paid
      $sub->status = \Config::get('constants.subscription_status.CANCELLED');
      $sub->save();
      Session::flash('flash_message', trans('messages.cancelled_successfully'));
      return redirect()->back();
  }

  public function revoke($id)
  {
      // change subscription status to pending
      Subscription::findOrFail($id)->status = \Config::get('constants.subscription_status.CANCELLED');

      // revoke credit

      // logging

      Session::flash('flash_message', trans('messages.marked_as_paid_successfully'));
      return redirect()->back();
  }
}
