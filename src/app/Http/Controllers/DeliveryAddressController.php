<?php

namespace App\Http\Controllers;

use App\Models\DeliveryAddress;
use App\Models\Item;
use App\Models\ResidentialAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $param = [
            "user_id" => Auth::id(),
            "postcode" => $request->postcode,
            "address" => $request->address,
            "building" => $request->building,
        ];

        $data_delivery_address = DeliveryAddress::with('user')->where('user_id', Auth::id())->first();
        if (empty($data_delivery_address)) {
            DeliveryAddress::create($param);
        } else {
            $data_delivery_address->update($param);
        }
        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }
}
