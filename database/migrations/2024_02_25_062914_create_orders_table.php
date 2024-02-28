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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // address_id
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            // subtotal
            $table->integer('subtotal');
            // shipping_cost
            $table->integer('shipping_cost');
            // total_price
            $table->integer('total_price');
            // status
            $table->enum('status', ['pending', 'paid', 'on_delivery', 'delivered', 'expired', 'canceled']);
            // payment_method
            $table->enum('payment_method', ['bank_transfer', 'ewallet']);
            // payment_va_name
            $table->string('payment_va_name')->nullable();
            // payment_va_number
            $table->string('payment_va_number')->nullable();
            // payment_ewallet_name
            $table->string('payment_ewallet_name')->nullable();
            // payment_ewallet_number
            $table->string('payment_ewallet_number')->nullable();
            // shipping_service
            $table->string('shipping_service');
            // resi
            $table->string('shipping_resi')->nullable();
            // transaction_number
            $table->string('transaction_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
