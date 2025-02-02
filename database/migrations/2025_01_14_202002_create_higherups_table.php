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
        Schema::create('higherups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('position', ['Yang Dipertua', 'Naib Dipertua I', 'Naib Dipertua II', 'Naib Dipertua III', 'Setiausaha', 'Timbalan Setiausaha', 'Bendahari', 'Timbalan Bendahari']);
            $table->string('picture');
            $table->integer('ranking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('higherups');
    }
};
