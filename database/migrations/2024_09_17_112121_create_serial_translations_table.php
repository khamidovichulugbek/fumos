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
        Schema::create('serial_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serial_id')->constrained('serials')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->char('locale', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_translations');
    }
};
