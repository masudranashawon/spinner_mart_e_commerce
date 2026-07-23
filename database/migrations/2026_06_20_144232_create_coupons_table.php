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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->string('coupon_type')->nullable();
            $table->decimal('discount', 10, 2)->nullable()->default(0);
            $table->decimal('min_amount', 10, 2)->nullable()->default(0);
            $table->integer('limit')->nullable()->default(0);
            $table->integer('total_applied')->nullable()->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
