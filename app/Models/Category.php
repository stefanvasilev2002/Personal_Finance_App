<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'color',
        'icon'
    ];
    public static function getDefaultCategory(string $type, int $userId): ?Category
    {
        return self::where('user_id', $userId)
            ->where('type', $type)
            ->where('name', 'Other ' . ucfirst($type))
            ->first();
    }

    public static function createDefaultCategory(string $type, int $userId): Category
    {
        return self::firstOrCreate(
            [
                'user_id' => $userId,
                'type' => $type,
                'name' => 'Other ' . ucfirst($type)
            ],
            [
                'color' => $type === 'income' ? '#4CAF50' : '#FF5722',
                'icon' => $type === 'income' ? 'wallet' : 'shopping-cart'
            ]
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
