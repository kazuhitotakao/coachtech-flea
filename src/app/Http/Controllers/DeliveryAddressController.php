<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DeliveryAddressController extends Controller
{
    public function editDeliveryAddress(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        return view('delivery_address', compact('item'));
    }

    public function updateDeliveryAddress(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        return view('purchase', compact('item'));
    }
}
