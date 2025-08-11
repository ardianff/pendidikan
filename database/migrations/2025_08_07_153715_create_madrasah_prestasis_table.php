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
        Schema::create('madrasah_prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('nsm');
            $table->string('nspn')->nullable();
            $table->unsignedBigInteger('jenjang');
            $table->string('tahun');
            $table->string('tk_kecamatan')->nullable();
            $table->string('tk_kab_kota')->nullable();
            $table->string('tk_provinsi')->nullable();
            $table->string('tk_nasional')->nullable();
            $table->string('tk_internasional')->nullable();
            $table->longText('keterangan')->nullable();
            $table->foreign('jenjang')->references('id')->on('master_jenjang_madrasahs')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('madrasah_prestasis');
    }
};
