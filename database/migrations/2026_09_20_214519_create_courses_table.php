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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        // Docente asignado al curso
        $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();
    });

    // Tabla intermedia para matricular alumnos en cursos
    Schema::create('course_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('course_user');
    Schema::dropIfExists('courses');
}
};
