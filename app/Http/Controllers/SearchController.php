<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Category;

class SearchController extends Controller
{
    public function index(Request $request){
      extract($request->all());
      if($q){
        $artworks = Artwork::search($q)->get();
        $categories = Category::all();
        return view('home', compact('artworks', 'categories'));
      }else{
        return redirect()->back()->with('error', 'no result found');
      }
    }
}
