<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => Item::factory(),  // Item モデルのファクトリを使用
            'user_id' => User::factory(), // User モデルのファクトリを使用
        ];
    }
}
