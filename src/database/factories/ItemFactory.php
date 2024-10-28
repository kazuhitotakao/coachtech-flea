<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'item_image_id' => null, // 省略可能な値
            'condition_id' => null, // 省略可能な値、必要に応じて具体的なIDを設定
            'brand_id' => null, // 省略可能な値、必要に応じて具体的なIDを設定
            'description' => $this->faker->text,
            'sale_price' => $this->faker->randomFloat(2, 10, 10000), // 10.00から10000.00までの価格
            'user_id' => User::factory(), // User ファクトリを使用してユーザーを自動生成
            'status' => $this->faker->randomElement(['available', 'sold']), // ステータスをランダムに選択
        ];
    }
}
