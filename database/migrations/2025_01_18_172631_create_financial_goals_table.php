<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('target_amount', 12);
            $table->decimal('current_amount', 12)->default(0);
            $table->date('target_date');
            $table->string('type'); // emergency_fund, vacation, down_payment, etc.
            $table->string('status')->default('in_progress'); // in_progress, completed, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
    }
};
