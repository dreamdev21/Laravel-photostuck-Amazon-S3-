<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Download;

class DashboardController extends Controller
{
    public function index(Request $request){
      if(\Auth::user()->can('contributor')){
        $artworks = \Auth::user()->contributor()->artworks()->orderBy('created_at', 'desc')->get();
        return view('contributors.dashboard', compact('artworks'));
      }elseif (\Auth::user()->can('customer')) {
        $downloads = Download::orderBy('created_at', 'desc')->get();
        return view('customers.dashboard' , compact('downloads'));
      }else{
        return redirect()->back();
      }
    }

}
