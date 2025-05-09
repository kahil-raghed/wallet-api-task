<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('type'); // enum TransactionType
            $table->integer('status'); // enum TransactionStatus
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->string('other_email')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('notes')->nullable();

            $table->index(['user_id', 'created_at']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
