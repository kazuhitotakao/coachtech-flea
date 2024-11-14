<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    // このファクトリがCategoryモデルに関するものと特定している
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'parent_id' => null // 初期状態では親カテゴリを持たない
        ];
    }

    /**
     * 親カテゴリを持つカテゴリの状態を定義
     */
    public function withParent($parent_id)
    {
        return $this->state(function (array $attributes) use ($parent_id) {
            return [
                'parent_id' => $parent_id
            ];
        });
    }
}
