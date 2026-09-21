<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'teacher_id'];

    // Docente a cargo
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Alumnos matriculados
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    // Tareas del curso
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}