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
                $img = ImageIntervention::make($image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                // リサイズした画像を保存
                $resize_img = $img->encode('jpg', 75); // JPEG形式で品質は75

                // 環境によって場合分け
                if (app('env') == 'local') {
                    $filename = $image->hashName();
                    Storage::disk('public')->put(
                        $directory . '/' . $filename,
                        (string) $resize_img
                    );
                    $image_paths[] = $directory . '/' . $filename;
                } elseif (app('env') == 'production') {
                    $filename = $image->hashName();
                    $path = Storage::disk('s3')->putFile('users', (string) $resize_img); //S3バケットのusersフォルダに、圧縮した画像を保存
                    $image_paths[] = Storage::disk('s3')->url($path); //直前に保存した画像のS3上で付与されたurlを取得 https://~
                } elseif (app('env') == 'testing') {
                    // テスト環境の処理を追加
                    $path = $image->store($directory, 'public');
                    $image_paths = $path;
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
