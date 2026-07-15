<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();  // ID session
            $table->foreignId('user_id')->nullable()->constrained('users'); // ID pengguna
            $table->text('payload');  // Payload session
            $table->integer('last_activity');  // Timestamp aktivitas terakhir
            $table->string('ip_address', 255)->nullable(); // Kolom ip_address
            $table->timestamps(); // Waktu pembuatan dan update data

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions'); // Menghapus tabel jika migrasi dibatalkan
    }
}

