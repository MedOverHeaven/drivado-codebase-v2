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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->enum('fuel_type', ['Essence', 'Diesel', 'Électrique', 'Hybride'])->nullable()->after('category');
            $table->string('seats')->default('5')->after('fuel_type');
            $table->enum('transmission', ['Automatique', 'Manuelle'])->default('Manuelle')->after('seats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['fuel_type', 'seats', 'transmission']);
        });
    }
};
