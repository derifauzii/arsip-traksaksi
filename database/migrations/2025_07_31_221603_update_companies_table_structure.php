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
            $table->dropColumn(['account_number', 'description']);
            $table->string('nomor_cs')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('account)number')->nullable();
            $table->text('description')->nullable();
            $table->dropColumn(['nomor_cs', 'email', 'alamat']);
        });
    }
};
