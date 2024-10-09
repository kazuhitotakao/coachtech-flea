<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postcode',
        'address',
        'building',
    ];

    public static function getUserAddress($user_id)
    {
        return self::with('user')
        ->where('user_id', $user_id)
            ->first();
    }

    public function getFormattedPostalCode()
    {
        return '〒' . substr($this->postcode, 0, 3) . '-' . substr($this->postcode, 3);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
