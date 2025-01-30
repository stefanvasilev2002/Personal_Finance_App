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
        'end_date',
        'period'
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

    public function isActive()
    {
        return !$this->end_date || now()->lte($this->end_date);
    }

    public function getCurrentSpending()
    {
        $endDate = $this->end_date ?? $this->getDefaultEndDate();
        $queryEndDate = now()->lte($endDate) ? now() : $endDate;

        return $this->category
            ->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$this->start_date, $queryEndDate])
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
        if (now()->gt($endDate)) {
            return 0;
        }
        return max(0, now()->diffInDays($endDate));
    }

    public function getStatus()
    {
        if (!$this->isActive()) {
            return 'expired';
        }

        $percentage = $this->getSpendingPercentage();
        if ($percentage > 90) {
            return 'over';
        }
        if ($percentage > 75) {
            return 'warning';
        }
        return 'good';
    }

    public function getDailyBudget()
    {
        $totalDays = max(1, $this->start_date->diffInDays($this->end_date ?? $this->getDefaultEndDate()));
        return $this->amount / $totalDays;
    }

    public function getDefaultEndDate()
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
