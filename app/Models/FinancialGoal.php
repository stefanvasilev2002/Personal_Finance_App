<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'current_amount',
        'target_date',
        'type',
        'status'
    ];

    protected $casts = [
        'target_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
