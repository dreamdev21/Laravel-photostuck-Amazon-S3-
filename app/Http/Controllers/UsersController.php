<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
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
        User::create($request->all());
        Session::flash('flash_message', trans('messages.added_successfully'));
        return redirect('users');
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
        $user = User::find($id);
        return view('users.show', compact('user'));
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
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update($request->all());
        Session::flash('success', trans('messages.updated_successfully'));
        return redirect('users');
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
        User::destroy($id);
        Session::flash('flash_message', trans('messages.deleted_successfully'));
        return redirect('users');
    }

    public function delete($id)
    {
        User::destroy($id);
        Session::flash('success', trans('messages.deleted_successfully'));
        return redirect('users');
    }

    public function changePassword(){
      return view('users.change-password');
    }
    public function postChangePassword(Request $request){

      $this->validate($request, [
          'old_password' => 'required|min:6|alpha_dash',
          'password' => 'required|min:6|alpha_dash|confirmed',
          'password_confirmation' => 'required|min:6|alpha_dash',
      ]);

      $user = Auth::user();
      if (Hash::check($request->old_password, $user->password)) {
          $user->password = Hash::make($request->password);
          $user->save();
          return redirect()->back()->with(['success' => trans('messages.updated_successfully')]);
      }
      return redirect()->back()->with(['error' => trans('messages.wrong_password')]);
    }
}
