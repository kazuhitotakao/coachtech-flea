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
     * ユーザーの住所とのリレーション (1対多)
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * 支払い方法との多対多リレーション
     */
    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class)
            ->withTimestamps();
    }

    /**
     * ユーザーが購入したアイテムとの多対多リレーション
     */
    public function purchases()
    {
        return $this->belongsToMany(Item::class, 'purchases')
            ->withTimestamps();
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
     * ユーザーがコメントしたアイテムとの多対多リレーション
     */
    public function comments()
    {
        return $this->belongsToMany(Item::class, 'comments')
            ->withPivot('comment')
            ->withTimestamps();
    }

    /**
     * ユーザーが所有するアイテムとの1対多リレーション
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
