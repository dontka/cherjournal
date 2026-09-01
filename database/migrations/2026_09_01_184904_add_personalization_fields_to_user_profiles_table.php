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
            $table->string('gender')->nullable()->after('username');
            $table->string('avatar_key')->nullable()->after('avatar_url');
            $table->string('theme')->default('rose')->after('avatar_key');
            $table->json('menu')->nullable()->after('theme');
            $table->unsignedInteger('points')->default(0)->after('menu');
            $table->boolean('onboarding_completed')->default(false)->after('points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'avatar_key',
                'theme',
                'menu',
                'points',
                'onboarding_completed',
            ]);
        });
    }
};
