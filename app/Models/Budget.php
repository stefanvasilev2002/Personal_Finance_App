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

    public function getCurrentSpending()
    {
        return $this->category
            ->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [
                $this->start_date,
                $this->end_date ?? $this->getDefaultEndDate()
            ])
            ->sum('amount');
    }

    public function getSpendingPercentage()
    {
        $spending = $this->getCurrentSpending();
        return $this->amount > 0 ? min(($spending / $this->amount) * 100, 100) : 0;
    }
    public function getRemainingDays()
    {
        $endDate = $this->end_date ?? $this->getDefaultEndDate();
        return round(max(0, now()->diffInDays($endDate)));
    }

    public function getDailyBudget()
    {
        $totalDays = max(1, $this->start_date->diffInDays($this->end_date ?? $this->getDefaultEndDate()));
        return $this->amount / $totalDays;
    }

    protected function getDefaultEndDate()
    {
        if ($this->period === 'monthly') {
            return $this->start_date->copy()->addMonth();
        }
        return $this->start_date->copy()->addYear();
    }

    public function getSpentPercentage()
    {
        $spending = $this->getCurrentSpending();
        return $this->amount > 0 ? min(($spending / $this->amount) * 100, 100) : 0;
    }
}
