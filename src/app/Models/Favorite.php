<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id'
    ];

    public static function like($user_id, $item_id)
    {
        $param = [
            "user_id" => $user_id,
            "item_id" => $item_id,
        ];
        $like = Favorite::create($param);

        return $like;
    }
}
