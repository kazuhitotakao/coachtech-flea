<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // ユーザー一覧
    public function indexUsers(Request $request)
    {
        $users = User::with('roles')->get();

        return view('admin_users_index', [
            'users' => $users,
        ]);
    }

    // ユーザー削除
    public function destroyUser(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();
        return redirect('/admin-page/users')->with('message', $user->name . 'さんを削除しました。');
    }

    // ユーザー検索
    public function searchUser(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/admin-page/users');
        }

        $query = User::query();
        $query = $this->getSearchUserQuery($request, $query);
        $users = $query->get();

        return view('admin_users_index', [
            'users' => $users,
        ]);
    }

    private function getSearchUserQuery($request, $query)
    {
        if (!empty($request->key)) {
            $query->where('name', 'like', '%' . $request->key . '%');
        }

        if (!empty($request->key)) {
            $query->orWhere('email', 'like', '%' . $request->key . '%');
        }

        return $query;
    }

    // コメント一覧
    public function indexComments(Request $request)
    {
        $comments = Comment::with('user', 'item')->get()->map(function ($comment) {
            $comment->user = User::find($comment->user->id);
            $comment->item = Item::find($comment->item->id);
            return $comment;
        });
        return view('admin_comments_index', [
            'comments' => $comments,
        ]);
    }

    // コメント削除
    public function destroyComment(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        return redirect('/admin-page/comments')->with('message', $comment->user->name . 'さんの『' . $comment->item->name . '』へのコメントを1つ削除しました。');
    }

    // コメント検索
    public function searchComment(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/admin-page/comments');
        }

        $query = Comment::with('user', 'item');
        $query = $this->getSearchCommentQuery($request, $query);
        $comments = $query->get()->map(function ($comment) {
            $comment->user = User::find($comment->user->id);
            $comment->item = Item::find($comment->item->id);
            return $comment;
        });

        return view('admin_comments_index', [
            'comments' => $comments,
        ]);
    }

    private function getSearchCommentQuery($request, $query)
    {
        if (!empty($request->key)) {
            $key = $request->key;

            $query->where(function ($query) use ($key) {
                // ユーザー名による検索
                $query->whereHas('user', function ($q) use ($key) {
                    $q->where('name', 'like', '%' . $key . '%');
                })
                    // アイテム名による検索
                    ->orWhereHas('item', function ($q) use ($key) {
                        $q->where('name', 'like', '%' . $key . '%');
                    })
                    // コメント内容による検索
                    ->orWhere('comment', 'like', '%' . $key . '%');
            });
        }

        return $query;
    }
}
