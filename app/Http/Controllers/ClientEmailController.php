<?php

namespace App\Http\Controllers;

use App\Models\ClientEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = ClientEmail::where('user_id', auth()->id())
            ->orderBy('is_primary', 'desc')
            ->orderBy('type')
            ->get();

        return view('pages.cuenta.emails.index', compact('emails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'type' => 'required|in:facturacion,ventas,admin,soporte,logistica,general',
            'notes' => 'nullable|string|max:500',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser un correo electrónico válido',
            'type.required' => 'El tipo de correo es obligatorio',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Si es el primer email, marcarlo como principal
        $isPrimary = ClientEmail::where('user_id', auth()->id())->count() === 0;

        ClientEmail::create([
            'user_id' => auth()->id(),
            'email' => $request->email,
            'type' => $request->type,
            'is_primary' => $isPrimary,
            'is_active' => true,
            'notes' => $request->notes,
        ]);

        return redirect()->route('client-emails.index')
            ->with('status', 'Correo electrónico añadido correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientEmail $clientEmail)
    {
        // Verificar que el email pertenece al usuario autenticado
        if ($clientEmail->user_id !== auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'type' => 'required|in:facturacion,ventas,admin,soporte,logistica,general',
            'notes' => 'nullable|string|max:500',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser un correo electrónico válido',
            'type.required' => 'El tipo de correo es obligatorio',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $clientEmail->update([
            'email' => $request->email,
            'type' => $request->type,
            'notes' => $request->notes,
        ]);

        return redirect()->route('client-emails.index')
            ->with('status', 'Correo electrónico actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientEmail $clientEmail)
    {
        // Verificar que el email pertenece al usuario autenticado
        if ($clientEmail->user_id !== auth()->id()) {
            abort(403);
        }

        // No permitir eliminar el email principal si hay otros emails
        if ($clientEmail->is_primary) {
            $otherEmails = ClientEmail::where('user_id', auth()->id())
                ->where('id', '!=', $clientEmail->id)
                ->count();

            if ($otherEmails > 0) {
                return back()->with('error', 'No se puede eliminar el correo principal. Primero establece otro correo como principal.');
            }
        }

        $clientEmail->delete();

        return redirect()->route('client-emails.index')
            ->with('status', 'Correo electrónico eliminado correctamente');
    }

    /**
     * Toggle primary status
     */
    public function setPrimary(ClientEmail $clientEmail)
    {
        // Verificar que el email pertenece al usuario autenticado
        if ($clientEmail->user_id !== auth()->id()) {
            abort(403);
        }

        // Quitar primary de todos los emails del usuario
        ClientEmail::where('user_id', auth()->id())->update(['is_primary' => false]);

        // Establecer este como primary
        $clientEmail->update(['is_primary' => true]);

        return redirect()->route('client-emails.index')
            ->with('status', 'Correo principal actualizado correctamente');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(ClientEmail $clientEmail)
    {
        // Verificar que el email pertenece al usuario autenticado
        if ($clientEmail->user_id !== auth()->id()) {
            abort(403);
        }

        // No permitir desactivar el email principal
        if ($clientEmail->is_primary && $clientEmail->is_active) {
            return back()->with('error', 'No se puede desactivar el correo principal.');
        }

        $clientEmail->update(['is_active' => !$clientEmail->is_active]);

        return redirect()->route('client-emails.index')
            ->with('status', 'Estado del correo actualizado correctamente');
    }
}
