<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavourController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favour($id);
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        \Auth::user()->unfavour($id);
        return redirect()->back();
    }
}
