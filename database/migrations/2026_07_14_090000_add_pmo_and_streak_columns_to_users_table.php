<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('pmo_notified')->default(false)->after('role');
            $table->integer('current_streak')->default(0)->after('pmo_notified');
            $table->integer('highest_streak')->default(0)->after('current_streak');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pmo_notified', 'current_streak', 'highest_streak']);
        });
    }
};