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
            $table->uuid('id')->primary()->unique();
            $table->string('nsm')->unique();
            $table->string('npsn')->unique()->nullable();
            $table->text('nama');
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->unsignedBigInteger('jenjang')->nullable();
            $table->string('provinsi');
            $table->string('kab_kota');
            $table->string('kecamatan');
            $table->string('kelurahan')->nullable();
            $table->text('alamat')->nullable();
            $table->text('konfirmasi');
            $table->enum('status', ['Negeri', 'Swasta']);
            $table->unsignedBigInteger('afiliasi_organisasi')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('active', [true, false]);
            $table->string('alias')->nullable();
            $table->enum('isVerif', [true, false]);
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
