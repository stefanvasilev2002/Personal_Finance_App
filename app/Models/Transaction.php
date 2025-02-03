<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'category_id',
        'amount',
        'type',
        'description',
        'date',
        'is_recurring'
    ];

    protected $casts = [
        'date' => 'date',
        'is_recurring' => 'boolean'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function executeRecurring()
    {
        if (!$this->is_recurring) {
            return null;
        }

        $newTransaction = $this->replicate();
        $newTransaction->date = now();
        $newTransaction->is_recurring = false;
        $newTransaction->save();

        $this->date = $this->date->addMonth();
        $this->save();

        return $newTransaction;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
