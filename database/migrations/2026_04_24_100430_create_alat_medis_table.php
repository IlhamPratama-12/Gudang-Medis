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
        Schema::create('alat_medis', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang')->unique();
        $table->string('nama_alat');
        $table->string('kategori_ruangan');
        $table->string('jenis_barang');
        $table->string('satuan');
        $table->integer('stok')->default(0);
        $table->integer('safety_stock')->default(0);
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_medis');
    }
};
