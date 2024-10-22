<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::find(Auth::id());
        $address = Address::where('user_id', Auth::id())->first();

        //商品画像関連処理 URL変換をモデル内で処理
        $image_urls = $user->getImageUrls();
        $image_url_thumbnail = $user->getThumbnailUrl();

        return view('profile', compact('user', 'address', 'image_urls', 'image_url_thumbnail'));
    }

    public function update(ProfileRequest $request)
    {
        $user = User::find(Auth::id());

        // ユーザー名とサムネイル画像更新
        $user->update([
            'name' => $request->user_name,
            'user_image_id' => $request->thumbnail_id,
        ]);

        // 住所更新 or 追加
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

        return redirect('/my-page/listed');
    }
}
