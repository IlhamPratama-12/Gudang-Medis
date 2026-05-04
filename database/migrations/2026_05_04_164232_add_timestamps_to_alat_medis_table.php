<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alat_medis', function (Blueprint $table) {

            // tambah created_at kalau belum ada
            if (!Schema::hasColumn('alat_medis', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            // tambah updated_at kalau belum ada
            if (!Schema::hasColumn('alat_medis', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('alat_medis', function (Blueprint $table) {

            if (Schema::hasColumn('alat_medis', 'created_at')) {
                $table->dropColumn('created_at');
            }

            if (Schema::hasColumn('alat_medis', 'updated_at')) {
                $table->dropColumn('updated_at');
            }

        });
    }
};