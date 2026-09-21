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
    Schema::create('submissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
        $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
        $table->string('file_path'); // Ruta del archivo subido
        $table->decimal('grade', 5, 2)->nullable(); // Calificación (ej. 20.00)
        $table->text('feedback')->nullable(); // Comentario del profesor
        $table->timestamps();
    });
}
};
