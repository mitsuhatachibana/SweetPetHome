<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Ubah dari INTEGER ke DECIMAL(2,1): 1.0 - 5.0
            $table->decimal('rating', 2, 1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('rating')->change();
        });
    }
};
