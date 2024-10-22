<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function editAddress(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        $address = Address::with('user')->where('user_id', Auth::id())->first();

        return view('address', compact('item', 'address'));
    }

    public function updateAddress(AddressRequest $request)
    {
        $item_id = $request->item_id;

        $param = [
            "user_id" => Auth::id(),
            "postcode" => $request->postcode,
            "address" => $request->address,
            "building" => $request->building,
        ];

        $address = Address::where('user_id', Auth::id())->first();
        if ($address) {
            $address->update($param);
        } else {
            Address::create($param);
        }
        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }
}
