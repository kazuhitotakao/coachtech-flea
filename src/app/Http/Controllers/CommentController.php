<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show(Request $request)
    {
        $item = Item::getItem($request->item_id);

        //商品画像関連処理 URL変換をモデル内で処理
        $image_urls = $item->getImageUrls();
        $image_url_thumbnail = $item->getThumbnailUrl();

        // コメントにユーザー画像のプロパティを追加
        $commentsWithThumbnails = $item->comments->map(function ($comment) {
            $user = $comment->user; // コメントからユーザーを取得
            $user_url_thumbnail = $user ? $user->getThumbnailUrl() : null; // ユーザーが存在する場合はサムネイルURLを取得、そうでない場合はnull
            $comment->user_url_thumbnail = $user_url_thumbnail; // コメントオブジェクトにサムネイルURLを新たなプロパティとして追加
            return $comment; // 変更されたコメントオブジェクトを返す
        });

        return view('comment', [
            'item' => $item,
            'brand_name' => optional($item->brand)->name,
            'image_urls' => $image_urls,
            'image_url_thumbnail' => $image_url_thumbnail,
            'favorites_count' => $item->favorites->count(),
            'comments' => $commentsWithThumbnails,
            'comments_count' => $item->comments->count(),
        ]);
    }

    public function store(Request $request)
    {
        $comment_content = $request->comment;
        $item_id = $request->item_id;

        Comment::createComment(Auth::id(), $item_id, $comment_content);

        return redirect()->route('comment.show', ['item_id' => $item_id]);
    }
}
