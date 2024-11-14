<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class UserImageController extends Controller
{
    public function upload(Request $request)
    {
        $user = User::find(Auth::id());

        // リクエストからファイルを取得してストレージに保存
        $directory = 'images/users';
        $image_paths = [];


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Intervention Imageを使用して画像をリサイズ
                $img = ImageIntervention::make($image)->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                // リサイズした画像を保存
                $resize_img = $img->encode('jpg', 75); // JPEG形式で品質は75
                $filename = $image->hashName();

                // 環境によって場合分け
                if (app('env') == 'local') {
                    Storage::disk('public')->put(
                        $directory . '/' . $filename,
                        $resize_img
                    );
                    $image_paths[] = $directory . '/' . $filename;
                } elseif (app('env') == 'production') {
                    // ファイルのパスを指定してS3にアップロード
                    $path = 'users/' . $filename;
                    Storage::disk('s3')->put($path, $resize_img);
                    // アップロードしたファイルのURLを取得
                    $url = Storage::disk('s3')->url($path);
                    $image_paths[] = $url;
                } elseif (app('env') == 'testing') {
                    // テスト環境の処理を追加
                    $directory = 'public/images/users';
                    $path = $image->store($directory, 'public');
                    $image_paths[] = $path;
                }
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
