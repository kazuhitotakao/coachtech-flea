<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function saveImages(Request $request)
    {
        // typeに基づいたセッションキーの決定
        $type = $request->input('type', 'items');
        $sessionKey = $type === 'items' ? 'uploaded_images_items' : 'uploaded_images_users';

        // 指定されたセッションキーから画像パスリストを取得
        $image_paths = Session::get($sessionKey, []);

        // 保存先ディレクトリを決定
        $directory = $type === 'items' ? 'public/images/items' : 'public/images/users';

        // リクエストからファイルを取得して保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (app('env') == 'local') {
                    $path = $image->store($directory);
                } elseif (app('env') == 'production') {
                    $path = Storage::disk('s3')->putFile('items', $image); //S3バケットのusersフォルダに、$imageを保存
                    $path = Storage::disk('s3')->url($path); //直前に保存した画像のS3上で付与されたurlを取得 https://~
                } elseif (app('env') == 'testing') {
                    // テスト環境の処理を追加
                    $path = $image->store($directory, 'local');
                }
                $image_paths[] = $path;
            }
        }

        // 更新された画像パスリストをセッションに保存
        Session::put($sessionKey, $image_paths);
    }
}
