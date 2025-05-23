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
        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('total_amount', 'total_amount'); // Renombrar la columna
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->change(); // Renombrar la columna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->decimal('total_amount', 8, 2)->change(); // Renombrar la columna
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('total_amount', 'total_amout'); // Renombrar la columna
        });
        
    }
};
