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
        Schema::create('serial_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serial_id')->constrained('serials')->cascadeOnDelete();
            $table->date('relased_date')->nullable();
            $table->string('country')->nullable();
            $table->integer('duration')->nullable();
            $table->decimal('rating', 3, 1);
            $table->integer('like')->default(0);
            $table->integer('views')->default(0);
            $table->string('trailer_url')->nullable();
            $table->string('production_company')->nullable();
            $table->json('awards')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_details');
    }
};
