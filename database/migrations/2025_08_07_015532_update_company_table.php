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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('nama_cs')->nullable(); // Menambahkan kolom nama_cs
            $table->dropColumn('email');          // Menghapus kolom email
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('nama_cs');        // Menghapus kolom nama_cs
            $table->string('email')->nullable();  // Mengembalikan kolom email
        });
    }
};
