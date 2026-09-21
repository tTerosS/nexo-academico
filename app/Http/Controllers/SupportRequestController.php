<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordResetRequest;
use App\Models\User;

class SupportRequestController extends Controller
{
    // Procesa el envío del usuario
    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|max:255',
        ]);

        PasswordResetRequest::create([
            'identifier' => $request->identifier,
            'status' => 'pendiente',
        ]);

        return back()->with('status', 'Tu solicitud fue recibida por la administración de NEXO ACADÉMICO. Un encargado se pondrá en contacto o puedes escribir directamente al soporte.');
    }

    // Listado para el Administrador
    public function index()
    {
        $requests = PasswordResetRequest::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.support.index', compact('requests'));
    }

    // Marcar como atendido o eliminar
    public function destroy(PasswordResetRequest $supportRequest)
    {
        $supportRequest->delete();
        return back()->with('success', 'Solicitud archivada correctamente.');
    }
}