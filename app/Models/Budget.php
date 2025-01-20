<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function isOverBudget()
    {
        $spending = $this->category
            ->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [
                $this->start_date,
                $this->end_date ?? now()
            ])
            ->sum('amount');

        return $spending > $this->amount;
    }

    // Recommended to also add this helper method for reuse
    public function getCurrentSpending()
    {
        return $this->category
            ->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [
                $this->start_date,
                $this->end_date ?? now()
            ])
            ->sum('amount');
    }

    public function getSpendingPercentage()
    {
        $spending = $this->getCurrentSpending();
        return $this->amount > 0 ? min(($spending / $this->amount) * 100, 100) : 0;
    }
}
