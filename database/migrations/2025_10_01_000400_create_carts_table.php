<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedInteger('quantity');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};


