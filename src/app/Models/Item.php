<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'item_image_id',
        'condition_id',
        'brand_id',
        'description',
        'sale_price',
        'user_id',
    ];

    public static function getItems()
    {
        $items = Item::with(['condition', 'brand', 'user', 'itemImages'])->with(
            'favorites',
            function ($query) {
                $query->where('user_id', Auth::id());
            }
        )->get();

        return $items;
    }

    public static function getItem($item_id)
    {
        $item = Item::with(['condition', 'brand', 'user', 'itemImages'])->with(
            'favorites',
            function ($query) {
                $query->where('user_id', Auth::id());
            }
        )->find($item_id);

        return $item;
    }

    public static function getLikeItems()
    {
        $userId = Auth::id();

        $items = Item::with(['condition', 'brand', 'user'])
            ->whereHas('favorites', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        return $items;
    }

    public function scopeSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhereHas('brand', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('categories', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%')
                            ->orWhereHas('parentCategory', function ($q) use ($keyword) {
                                $q->where('name', 'like', '%' . $keyword . '%');
                            });
                    });
            });
        }
    }

    // カテゴリ名を取得する（重複なしの一覧を配列として返す）
    public function getCategoryNames()
    {
        return $this->categories->flatMap(function ($category) {
            // ここで各カテゴリーのすべての祖先カテゴリーを取得し、その名前だけをリスト化
            return $category->getAncestors()->pluck('name');
        })->unique()->toArray(); // 重複を排除して、配列として返す
    }

    /**
     * すべての画像のURLを取得する。
     */
    public function getImageUrls()
    {
        $imageUrls = $this->itemImages->map(function ($itemImage) {
            return $this->resolveImageUrl($itemImage->image_path);
        })->all();

        // サムネイルとして設定されている画像のIDがある場合、その画像をリストの先頭に移動
        if ($this->item_image_id) {
            $thumbnailUrl = $this->getThumbnailUrl(); // サムネイル画像のURLを取得
            if (($key = array_search($thumbnailUrl, $imageUrls)) !== false) {
                unset($imageUrls[$key]); // 元の位置からサムネイル画像を削除
                array_unshift($imageUrls, $thumbnailUrl); // 画像リストの最初にサムネイル画像を挿入
            }
        }

        return $imageUrls;
    }

    /**
     * サムネイル画像（detailページの大きい画像に使用）のURLを取得する。
     */
    public function getThumbnailUrl()
    {
        $thumbnailImage = $this->item_image_id ? ItemImage::find($this->item_image_id) : null;
        return $thumbnailImage ? $this->resolveImageUrl($thumbnailImage->image_path) : '';
    }

    /**
     * 画像パスからURLを解決するヘルパーメソッド。
     */
    private function resolveImageUrl($imagePath)
    {
        return strpos($imagePath, 'http') === 0 ? $imagePath : Storage::url($imagePath);
    }

    public function calculatePaidPrice($payment_method_id)
    {
        $paid_price = $this->sale_price;
        $paid_price_format = number_format($this->sale_price);

        if ($payment_method_id == 2) {
            $paid_price += 500;
            $paid_price_format = number_format($paid_price) . '（手数料500円）';
        } elseif ($payment_method_id == 3) {
            $paid_price += 300;
            $paid_price_format = number_format($paid_price) . '（手数料300円）';
        }

        return [
            'paid_price' => $paid_price,
            'paid_price_format' => $paid_price_format,
        ];
    }



    /**
     * ユーザーとのリレーション (多対1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * アイテム画像とのリレーション (1対多)
     */
    public function itemImages()
    {
        return $this->hasMany(ItemImage::class);
    }

    /**
     * 状態テーブルとのリレーション (多対1)
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * ブランドとのリレーション (多対1)
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * カテゴリとのリレーション (多対多)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item')
            ->withTimestamps();
    }

    /**
     * コメントとのリレーション (1対多）
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * お気に入りとのリレーション (多対多)
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * 購入履歴とのリレーション (1対1)
     */
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
