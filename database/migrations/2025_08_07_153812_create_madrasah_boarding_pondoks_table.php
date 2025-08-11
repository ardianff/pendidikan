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
        Schema::create('madrasah_boarding_pondoks', function (Blueprint $table) {
            $table->id();
            $table->string('nsm');
            $table->string('nspn')->nullable();
            $table->unsignedBigInteger('jenjang');
            $table->string('tahun');
            $table->boolean('is_boarding')->nullable();
            $table->boolean('is_pondok')->nullable();
            $table->unsignedBigInteger('boarding_putra')->nullable();
            $table->unsignedBigInteger('boarding_putri')->nullable();
            $table->unsignedBigInteger('pondok_putra')->nullable();
            $table->unsignedBigInteger('pondok_putri')->nullable();

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
        Schema::dropIfExists('madrasah_boarding_pondoks');
    }
};
