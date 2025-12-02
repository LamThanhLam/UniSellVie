<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Temporary add column as nullable
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });
        
        // Add foreign key (after data is cleared)
        Schema::table('products', function (Blueprint $table) {
            // Add foreign key reference to id of users table, and automatically delete product when user get deleted
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
