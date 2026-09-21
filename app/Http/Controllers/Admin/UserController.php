<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:administrador,docente,alumno',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->email === 'admin@osalvac.pe') {
            return back()->with('error', 'No puedes eliminar la cuenta maestra de GRUPO OSALVAC SRL.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = fopen($request->file('csv_file')->getRealPath(), 'r');
        
        // Omitir encabezado si existe
        fgetcsv($file);

        $imported = 0;
        // Formato esperado por fila: Nombre, Correo, Rol (administrador/docente/alumno), Contraseña
        while (($row = fgetcsv($file, 1000, ',')) !== false) {
            if (count($row) >= 4) {
                $name = trim($row[0]);
                $email = trim($row[1]);
                $role = strtolower(trim($row[2]));
                $password = trim($row[3]);

                if (!in_array($role, ['administrador', 'docente', 'alumno'])) {
                    $role = 'alumno';
                }

                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'role' => $role,
                        'password' => Hash::make($password),
                    ]
                );
                $imported++;
            }
        }
        fclose($file);

        return redirect()->route('admin.users.index')->with('success', "Se importaron $imported usuarios correctamente desde el CSV.");
    }
}