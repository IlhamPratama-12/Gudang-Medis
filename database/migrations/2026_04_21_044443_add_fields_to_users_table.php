<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('nip')->after('name');

            $table->enum('status', ['pending','approved'])
                  ->default('pending')
                  ->after('role');

            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('nip');
            $table->dropColumn('status');

            $table->string('password')->nullable(false)->change();
        });
    }
};