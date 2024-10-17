<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ImageService
{
    public function saveImages(Request $request)
    {
        // typeに基づいたセッションキーの決定
        $type = $request->input('type', 'items');
        $sessionKey = $type === 'items' ? 'uploaded_images_items' : 'uploaded_images_users';

        // 指定されたセッションキーから画像パスリストを取得
        $imagePaths = Session::get($sessionKey, []);

        // 保存先ディレクトリを決定
        $directory = $type === 'items' ? 'public/images/items' : 'public/images/users';

        // リクエストからファイルを取得して保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store($directory);
                $imagePaths[] = $path;
            }
        }

        // 更新された画像パスリストをセッションに保存
        Session::put($sessionKey, $imagePaths);
    }
}