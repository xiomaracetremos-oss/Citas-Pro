<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->foreignId('especialista_id')->nullable()->change();
            $table->date('fecha')->nullable()->change();
            $table->time('hora')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->foreignId('especialista_id')->nullable(false)->change();
            $table->date('fecha')->nullable(false)->change();
            $table->time('hora')->nullable(false)->change();
        });
    }
};
