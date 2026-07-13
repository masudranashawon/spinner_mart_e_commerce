<?php

use App\Models\Order;
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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('country');
            $table->string('city');
            $table->string('post_code');
            $table->string('company')->nullable();
            $table->string('email')->nullable();;
            $table->string('phone');
            $table->text('address');
            $table->text('message')->nullable();
            $table->string('address_type');
            $table->unique(['order_id', 'address_type']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
