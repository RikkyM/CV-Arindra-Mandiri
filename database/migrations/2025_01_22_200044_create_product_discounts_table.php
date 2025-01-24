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
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('min_qty');
            $table->integer('max_qty')->nullable();
            $table->decimal('persentase_diskon', 5, 2);
            $table->enum('user_role', ['toko', 'konsumen']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_discounts');
    }
};
