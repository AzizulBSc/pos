<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->double('discount')->default(0);
            $table->double('sub_total')->default(0)->comment('sumOf(total) from order_products table');
            $table->double('total')->default(0)->comment('sub_total - discount');
            $table->double('paid')->default(0)->comment('customer paid amount');
            $table->double('due')->default(0)->comment('total - paid');
            $table->text('note')->nullable();
            $table->boolean('is_returned')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sale::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->double('sub_total')->default(0);
            $table->double('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
        Schema::dropIfExists('sale_products');
    }
};
