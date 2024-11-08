<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

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
        $directory = $type === 'items' ? 'images/items' : 'images/users';

        // リクエストからファイルを取得して保存
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
                    $path = 'items/' . $filename;
                    Storage::disk('s3')->put($path, $resize_img);
                    // アップロードしたファイルのURLを取得
                    $url = Storage::disk('s3')->url($path);
                    $image_paths[] = $url;
                } elseif (app('env') == 'testing') {
                    // テスト環境の処理を追加
                    $directory_test = 'public/' . $directory;
                    $path = $image->store($directory_test, 'local');
                    $image_paths[] = $path;
                }
            }
        }
        // 更新された画像パスリストをセッションに保存
        Session::put($sessionKey, $image_paths);
    }
}
