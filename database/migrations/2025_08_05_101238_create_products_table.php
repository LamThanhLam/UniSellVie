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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('image')->nullable();
            $table->date('releaseDate');
            $table->text('developer')->nullable();
            $table->text('publisher');
            $table->text('description')->nullable();
            $table->string('platform')->nullable();
            $table->string('genre')->nullable();
            $table->longText('content')->nullable();
            $table->decimal('price', 8, 2)->default(0); //8 for total number and 2 is for 2 numbers after the decimal point, 0 is the default price
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
