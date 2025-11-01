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
    Schema::create('titik', function (Blueprint $table) {
        $table->id();
        $table->string('nama_titik');
        $table->float('latitude');
        $table->float('longitude');
        $table->integer('hasil')->nullable(); // kg
        $table->date('waktu_panen')->nullable();
        $table->string('estimasi_panen')->nullable(); // bulan
        $table->date('terakhir_pemupukan')->nullable();
        $table->string('jenis_pupuk')->nullable();
        $table->integer('jumlah_pupuk')->nullable(); // kg
        $table->string('edited_by')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik');
    }
};
