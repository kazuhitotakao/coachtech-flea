<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserImageController extends Controller
{
    public function upload(Request $request)
    {
        $user = User::find(Auth::id());

        // リクエストからファイルを取得してストレージに保存
        $directory = 'public/images/users';
        $image_paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store($directory);
                $image_paths[] = $path;
            }
        }

        // 前処理でストレージに保存したものをuser_magesテーブルに保存
        $images_data = [];
        foreach ($image_paths as $path) {
            $images_data[] = new UserImage(['image_path' => $path]);
        }
        $user->userImages()->saveMany($images_data); // すべての画像データを一括でデータベースに保存

        return redirect('/my-page/profile');
    }
}
