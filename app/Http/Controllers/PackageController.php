<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
      $packages = Package::paginate($perPage);
      return view('packages.index', compact('packages'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
      return view('packages.create');
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
      Package::create($request->all());
      Session::flash('flash_message', trans('messages.added_successfully'));
      return redirect('packages');
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
      $package = Package::findOrFail($id);
      return view('packages.show', compact('package'));
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
      $package = Package::findOrFail($id);
      return view('packages.edit', compact('package'));
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
      $package = Package::findOrFail($id);
      $package->update($request->all());
      Session::flash('flash_message', trans('messages.updated_successfully'));
      return redirect('packages');
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
      Package::destroy($id);
      Session::flash('flash_message', trans('messages.deleted_successfully'));
      return redirect('packages');
  }
}
