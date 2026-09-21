<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $institution_name = Setting::get('institution_name', 'GRUPO OSALVAC SRL');
        $primary_color = Setting::get('primary_color', '#4f46e5');
        $welcome_message = Setting::get('welcome_message', 'Bienvenido a la plataforma educativa NEXO Campus.');

        return view('admin.settings.edit', compact('institution_name', 'primary_color', 'welcome_message'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7',
            'welcome_message' => 'nullable|string',
        ]);

        Setting::updateOrCreate(['key' => 'institution_name'], ['value' => $request->institution_name]);
        Setting::updateOrCreate(['key' => 'primary_color'], ['value' => $request->primary_color]);
        Setting::updateOrCreate(['key' => 'welcome_message'], ['value' => $request->welcome_message]);

        return back()->with('success', 'Configuración visual actualizada correctamente.');
    }
}