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
        Schema::table('reviews', function (Blueprint $table) {
            // Drop the profile_id column
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
            
            // Add reviewer_id column
            $table->foreignId('reviewer_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Drop reviewer_id column
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn('reviewer_id');
            
            // Add back profile_id column
            $table->foreignId('profile_id')->after('id')->constrained()->onDelete('cascade');
        });
    }
};
