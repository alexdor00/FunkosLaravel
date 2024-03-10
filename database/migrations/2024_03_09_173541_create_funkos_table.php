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
        Schema::create('funkos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('modelo');
            $table->text('descripcion');
            $table->string('imagen')->default('https://via.placeholder.com/150');
            $table->decimal('precio', 10, 2);
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade'); 
            $table->boolean('isDeleted')->default(false);
            $table->integer('stock');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funkos');
    }
};
