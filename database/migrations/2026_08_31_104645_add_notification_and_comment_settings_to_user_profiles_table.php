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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->boolean('email_notifications')->default(true)->after('avatar_url');
            $table->boolean('in_app_notifications')->default(true)->after('email_notifications');
            $table->boolean('comments_enabled')->default(true)->after('in_app_notifications');
            $table->boolean('comment_moderation')->default(false)->after('comments_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'email_notifications',
                'in_app_notifications',
                'comments_enabled',
                'comment_moderation',
            ]);
        });
    }
};
