<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        'status',
    ];

    // 全商品取得
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

    // 商品取得
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

    // 出品した全商品取得
    public static function getListedItems()
    {
        $items = Item::with(['condition', 'brand', 'user', 'itemImages'])->with(
            'favorites',
            function ($query) {
                $query->where('user_id', Auth::id());
            }
        )
            ->where('user_id', Auth::id())
            ->get();

        return $items;
    }

    // 購入した全商品取得
    public static function getPurchasedItems()
    {
        $purchased_ids = Purchase::where('buyer_id', Auth::id())->pluck('item_id');

        $items = Item::with(['condition', 'brand', 'user', 'itemImages', 'favorites'])
            ->whereIn('id', $purchased_ids)
            ->get();

        return $items;
    }

    // お気に入りをした全商品取得
    public static function getLikeItems()
    {
        $user_id = Auth::id();

        $items = Item::with(['condition', 'brand', 'user'])
            ->whereHas('favorites', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->get();
        return $items;
    }

    // 検索処理
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

    // カテゴリーIDを取得する（重複なしの一覧を配列として返す）
    public function getCategoryIds()
    {
        return $this->categories->flatMap(function ($category) {
            // ここで各カテゴリーのすべての祖先カテゴリーを取得し、その名前だけをリスト化
            return $category->getAncestors()->pluck('id');
        })->unique()->toArray(); // 重複を排除して、配列として返す
    }

    /**
     * すべての画像のURLを取得する。
     */
    public function getImageUrls()
    {
        $image_urls = $this->itemImages->map(function ($item_image) {
            return $this->resolveImageUrl($item_image->image_path);
        })->all();

        // サムネイルとして設定されている画像のIDがある場合、その画像をリストの先頭に移動
        if ($this->item_image_id) {
            $thumbnail_url = $this->getThumbnailUrl(); // サムネイル画像のURLを取得
            if (($key = array_search($thumbnail_url, $image_urls)) !== false) {
                unset($image_urls[$key]); // 元の位置からサムネイル画像を削除
                array_unshift($image_urls, $thumbnail_url); // 画像リストの最初にサムネイル画像を挿入
            }
        }

        return $image_urls;
    }

    /**
     * サムネイル画像のURLを取得する。
     */
    public function getThumbnailUrl()
    {
        $thumbnail_image = $this->item_image_id ? ItemImage::find($this->item_image_id) : null;
        return $thumbnail_image ? $this->resolveImageUrl($thumbnail_image->image_path) : '';
    }

    /**
     * 画像パスからURLを解決するヘルパーメソッド。
     */
    private function resolveImageUrl($image_path)
    {
        return strpos($image_path, 'http') === 0 ? $image_path : Storage::url($image_path);
    }

    // 購入時の手数料計算
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

    // 商品を出品するメソッド
    public static function createWithDetails(Request $request)
    {
        // 1 出品する商品レコードを作成 （itemsテーブルのidの作成）
        $item = self::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);
        // 2 画像一覧からitem_imagesテーブルを作成 (item_imagesテーブルのidの作成)
        $item->storeImages(session()->get('uploaded_images_items', []));
        // 3 サムネイルに選択した画像のidを取得し、出品する商品レコードのitem_image_idに保存
        $item->setThumbnail($request->thumbnail_index);
        // 4 選択されたカテゴリーid（複数可）をitemsとcategoriesの中間テーブルに保存
        $item->attachCategories($request->category_ids);
        // 5 その他の商品詳細を出品する商品レコードに保存
        $item->updateItemDetails($request);
        session()->forget('uploaded_images_items');
    }

    // 商品画像をデーターベースに保存する処理
    public function storeImages($image_paths)
    {
        $images_data = [];
        foreach ($image_paths as $path) {
            $images_data[] = new ItemImage(['image_path' => $path]);
        }
        $this->itemImages()->saveMany($images_data); // すべての画像データを一括でデータベースに保存
    }

    // itemsテーブルのitem_image_idにサムネイルの画像IDを保存
    public function setThumbnail($index)
    {
        $thumbnail = $this->itemImages()->skip($index)->first(); //ユーザーが選択したインデックス（$index で指定）の数だけ画像レコードの取得をスキップ。
        if ($thumbnail) {
            $this->item_image_id = $thumbnail->id;
            $this->save();
        }
    }

    // categoryテーブルとの中間テーブルにデータを保存
    public function attachCategories($category_ids)
    {
        $this->categories()->attach($category_ids);
    }

    // 商品の詳細情報を更新
    public function updateItemDetails(Request $request)
    {
        $this->update([
            'condition_id' => $request->condition_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'sale_price' => $this->convertToNumber($request->sale_price),
        ]);
    }

    // 売り切れかどうかをチェックするメソッド
    public function isSold()
    {
        return $this->status === 'sold';
    }

    // ステータスを「販売済み」に変更するメソッド
    public function markAsSold()
    {
        $this->status = 'sold';
        $this->save();
    }

    //3桁区切りの金額を数値に変換する
    public function convertToNumber($number)
    {
        $formatted_number = str_replace(',', '', $number);
        // 文字列を整数に変換
        $formatted_number = (int)$formatted_number;
        return $formatted_number;
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
