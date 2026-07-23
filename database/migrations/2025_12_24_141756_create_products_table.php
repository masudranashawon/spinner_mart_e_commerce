<?php

use App\Models\Media;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('sku_code');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('buying_price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->default(0);
            $table->integer('reviews')->default(0);
            $table->integer('rating')->default(0);
            $table->foreignIdFor(Media::class)->nullable()->constrained()->cascadeOnDelete();
            $table->integer('sold_count')->default(0);
            $table->boolean('is_deal_of_the_day')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
