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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->decimal('total_price', 10, 2);
            $table->boolean('discount')->default(false);
            $table->foreignId('status_id')->constrained('order_statuses')->restrictOnDelete();
            $table->text('cancel_reason')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('phone_number');
            $table->text('notes')->nullable();
            $table->string('promo_code')->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
