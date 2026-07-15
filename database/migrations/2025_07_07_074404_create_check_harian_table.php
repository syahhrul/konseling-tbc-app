<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('check_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('suhu', 5, 2);
            $table->decimal('berat', 5, 2);
            $table->string('nafsu_makan');
            $table->enum('minum_obat', ['Ya', 'Tidak']);
            $table->string('catatan_pete');
            $table->boolean('status_minum_obat')->nullable();
            $table->text('alasan_tidak_minum')->nullable();
            $table->integer('frekuensi_batuk')->nullable();
            $table->float('suhu_tubuh')->nullable();
            $table->boolean('berkeringat_malam')->nullable();
            $table->float('berat_badan')->nullable();
            $table->text('catatan_bebas')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_harian');
    }
};

