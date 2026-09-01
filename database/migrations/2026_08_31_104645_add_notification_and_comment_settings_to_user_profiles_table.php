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
        if (Schema::hasTable('user_profiles')) {
            if (Schema::hasColumn('user_profiles', 'avatar') && ! Schema::hasColumn('user_profiles', 'avatar_url')) {
                Schema::table('user_profiles', function (Blueprint $table) {
                    $table->renameColumn('avatar', 'avatar_url');
                });
            }

            if (! Schema::hasColumn('user_profiles', 'email_notifications')) {
                Schema::table('user_profiles', function (Blueprint $table) {
                    $table->boolean('email_notifications')->default(true)->after('avatar_url');
                });
            }

            if (! Schema::hasColumn('user_profiles', 'in_app_notifications')) {
                Schema::table('user_profiles', function (Blueprint $table) {
                    $table->boolean('in_app_notifications')->default(true)->after('email_notifications');
                });
            }

            if (! Schema::hasColumn('user_profiles', 'comments_enabled')) {
                Schema::table('user_profiles', function (Blueprint $table) {
                    $table->boolean('comments_enabled')->default(true)->after('in_app_notifications');
                });
            }

            if (! Schema::hasColumn('user_profiles', 'comment_moderation')) {
                Schema::table('user_profiles', function (Blueprint $table) {
                    $table->boolean('comment_moderation')->default(false)->after('comments_enabled');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('user_profiles')) {
            if (Schema::hasColumn('user_profiles', 'avatar_url') && ! Schema::hasColumn('user_profiles', 'avatar')) {
                Schema::table('user_profiles', function (Blueprint $table) {
                    $table->renameColumn('avatar_url', 'avatar');
                });
            }

            Schema::table('user_profiles', function (Blueprint $table) {
                $columns = ['email_notifications', 'in_app_notifications', 'comments_enabled', 'comment_moderation'];

                foreach ($columns as $column) {
                    if (Schema::hasColumn('user_profiles', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
