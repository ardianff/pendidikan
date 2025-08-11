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
        Schema::create('madrasah_perguruan_tinggis', function (Blueprint $table) {
            $table->id();
            $table->string('nsm');
            $table->string('nspn')->nullable();
            $table->unsignedBigInteger('jenjang');
            $table->string('tahun');
            $table->unsignedBigInteger('ptn');
            $table->unsignedBigInteger('pts');
            $table->unsignedBigInteger('ptkin');
            $table->unsignedBigInteger('ptkis');
            $table->unsignedBigInteger('kedinasan');
            $table->unsignedBigInteger('tni');
            $table->unsignedBigInteger('polri');
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
        Schema::dropIfExists('madrasah_perguruan_tinggis');
    }
};
