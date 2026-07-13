<?php

use App\Models\Coupon;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number')->unique()->nullable();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Coupon::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->decimal('grand_total', 10, 2);
            $table->boolean('has_coupon')->default(false);
            $table->string('order_status')->nullable();
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->boolean('has_payment')->default(false);
            $table->text('note')->nullable();
            $table->string('payment_status');

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
