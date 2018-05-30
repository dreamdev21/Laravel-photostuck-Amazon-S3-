<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //\Session::flash('topbar_message', 'RAMADAN KAREEM. We are comming with new collection for Ramadan. Be ready :)');
        if(\Auth::check()){
          if(\Auth::user()->can('contributor')){
            if(\Auth::user()->contributor()->status == \Config::get('constants.contributor_status.PENDING')){
              \Session::flash('warning', trans('messages.account_pending'));
            }elseif (\Auth::user()->contributor()->status == \Config::get('constants.contributor_status.REJECTED')) {
              \Session::flash('error', trans('messages.account_rejected'));
            }
          }
          return $next($request);
        }
        return redirect('/login');
    }
}
