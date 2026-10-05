<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 12, 2);
            $table->string('payment_method');
            $table->string('status')->default('pending'); // pending, shopped, delivered
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
