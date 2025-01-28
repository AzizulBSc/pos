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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->morphs('payable'); // Polymorphic relation (purchase or sale)
            $table->enum('payment_type', ['cash', 'bank_transfer', 'credit_card', 'mobile_payment', 'others']);
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->nullable(); // Optional note for the payment
            $table->text('note')->nullable(); // Optional note for the payment
            $table->enum('transaction_type', ['debit', 'credit'])->default('credit'); // 'credit' for income, 'debit' for expense
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Optional: the user handling the payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
