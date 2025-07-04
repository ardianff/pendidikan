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
        Schema::create('master_madrasahs', function (Blueprint $table) {
            $table->uuid()->primary()->unique();
            $table->string('nsm');
            $table->string('npsn');
            $table->text('nama');
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->unsignedBigInteger('jenjang');
            $table->string('provinsi');
            $table->string('kab_kota');
            $table->string('kecamatan');
            $table->string('kelurahan')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('konfirmasi', [true, false]);
            $table->enum('status', ['Negeri', 'Swasta']);
            $table->unsignedBigInteger('afiliasi_organisasi');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('active', [true, false]);
            $table->string('alias')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_madrasahs');
    }
};
