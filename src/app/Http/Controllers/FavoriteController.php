<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store($item_id)
    {
        Favorite::like(Auth::id(), $item_id);
        return redirect()->back();;
    }

    public function delete($item_id)
    {
        Favorite::where('user_id', Auth::id())->where('item_id', $item_id)->delete();
        return redirect()->back();
    }
}
