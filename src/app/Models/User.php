<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    /**
     * ユーザーのプロフィール画像とのリレーション (1対多)
     */
    public function images()
    {
        return $this->hasMany(UserImage::class);
    }

    /**
     * ユーザーの住所とのリレーション (1対1)
     */
    public function residentialAddress()
    {
        return $this->hasOne(ResidentialAddress::class);

    }
    /**
     * ユーザーの配送先とのリレーション (1対1)
     */
    public function deliveryAddress()
    {
        return $this->hasOne(DeliveryAddress::class);
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
}
