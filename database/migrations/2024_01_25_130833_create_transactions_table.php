<?php

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
            $table->id();
            $table->string('transaction_id')->unique();
            $table->decimal('amount');
            $table->decimal('paid_amount')->default(0);
            $table->decimal('balance')->default(0);
            $table->string('payer');
            $table->date('due_on');
            $table->decimal('vat')->default(0);
            $table->boolean('is_vat_inclusive')->default(false);
            $table->enum('status', ['Paid', 'Outstanding', 'Overdue']);
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
