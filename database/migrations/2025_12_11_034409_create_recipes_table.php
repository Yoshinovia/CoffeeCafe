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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade');
            $table->decimal('quantity_used', 10, 2);
            $table->string('unit_used');
            $table->unique(['menu_id', 'raw_material_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
