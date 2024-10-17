<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_image_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUser($user_id)
    {
        $user = User::with(['address', 'userImages'])->find($user_id);

        return $user;
    }

    /**
     * すべての画像のURLを取得する。
     */
    public function getImageUrls()
    {
        $image_urls = $this->userImages->map(function ($user_image) {
            return [
                'id' => $user_image->id,  // 画像のIDを取得
                'url' => $this->resolveImageUrl($user_image->image_path)  // 画像のURLを取得
            ];
        })->all();

        // サムネイルとして設定されている画像のIDがある場合、その画像をリストの先頭に移動
        if ($this->user_image_id) {
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
        $thumbnail_image = $this->user_image_id ? UserImage::find($this->user_image_id) : null;
        return $thumbnail_image ? $this->resolveImageUrl($thumbnail_image->image_path) : '';
    }

    /**
     * 画像パスからURLを解決するヘルパーメソッド。
     */
    private function resolveImageUrl($image_path)
    {
        return strpos($image_path, 'http') === 0 ? $image_path : Storage::url($image_path);
    }

    /**
     * ユーザーのプロフィール画像とのリレーション (1対多)
     */
    public function userImages()
    {
        return $this->hasMany(UserImage::class);
    }

    /**
     * ユーザーの住所とのリレーション (1対1)
     */
    public function address()
    {
        return $this->hasOne(Address::class);

    }


    /**
     * ユーザーがお気に入りにしたアイテムとの多対多リレーション
     */
    public function favorites()
    {
        return $this->belongsToMany(Item::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * ユーザーとコメントとの１対多リレーション
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * ユーザーが購入者として関わる購入履歴を取得します（hasManyリレーション）。
     */
    public function purchasesAsBuyer()
    {
        return $this->hasMany(Purchase::class, 'buyer_id');
    }

    /**
     * ユーザーが出品者として関わる購入履歴を取得します（hasManyリレーション）。
     */
    public function purchasesAsSeller()
    {
        return $this->hasMany(Purchase::class, 'seller_id');
    }

    /**
     * ユーザーが所有するアイテムとの1対多リレーション
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * ユーザーと支払方法詳細のリレーション (1対多)
     */
    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }

}
