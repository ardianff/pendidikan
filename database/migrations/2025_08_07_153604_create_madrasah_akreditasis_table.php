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
        Schema::create('madrasah_akreditasis', function (Blueprint $table) {
            $table->id();
            $table->string('nsm');
            $table->string('nspn')->nullable();
            $table->unsignedBigInteger('jenjang');
            $table->string('tahun');
            $table->string('nilai');
            $table->string('skor');
            $table->text('dok_piagam')->nullable();
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
        Schema::dropIfExists('madrasah_akreditasis');
    }
};
