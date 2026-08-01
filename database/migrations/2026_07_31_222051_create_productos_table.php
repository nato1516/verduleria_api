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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100);
            $table->string('categoria', 100);
            $table->text('descripcion');

            $table->decimal('precio', 10, 2);
            $table->decimal('precio_mayor', 10, 2)->nullable();

            $table->string('image_path')->nullable();

            $table->string('modal_id', 100)->nullable();

            $table->string('activo', 20)->default('activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
