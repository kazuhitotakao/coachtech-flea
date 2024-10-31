<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
                if (app('env') == 'local') {
                    $path = $image->store($directory);
                } elseif (app('env') == 'production') {
                    $path = Storage::disk('s3')->putFile('users', $image); //S3バケットのusersフォルダに、$imageを保存
                    $path = Storage::disk('s3')->url($path); //直前に保存した画像のS3上で付与されたurlを取得 https://~
                }
                $image_paths[] = $path;
            }
        }

        // 前処理でストレージに保存したものをuser_imagesテーブルに保存
        $images_data = [];
        foreach ($image_paths as $path) {
            $images_data[] = new UserImage(['image_path' => $path]);
        }
        $user->userImages()->saveMany($images_data); // すべての画像データを一括でデータベースに保存

        return redirect('/my-page/profile');
    }
}
