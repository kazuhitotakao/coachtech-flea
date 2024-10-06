<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'comment',
    ];

    public static function createComment($user_id, $item_id, $comment_content)
    {
        $param = [
            "user_id" => $user_id,
            "item_id" => $item_id,
            "comment" => $comment_content,
        ];
        $comment = Comment::create($param);

        return $comment;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
