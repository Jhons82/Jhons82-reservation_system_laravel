<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index() {
        $usuarios = User::with('role')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create() {
        //Obtener los roles
        $roles = Role::all();
        //Devuelve vista de crear usuario, con los roles
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request) {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'rol_id' => 'required|exists:roles,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8', //Agregar al final |confirmed para confirmar la contraseña en caso se necesite
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }

        User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'foto' => $fotoPath,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id) {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Permite el mismo email para el usuario actual
            'rol_id' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $usuario = User::findOrFail($id);

        $data = $request->only(['nombres', 'apellidos', 'telefono', 'email', 'rol_id']);

        /* if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } */

        if ($request->hasFile('foto')) {
            // Guardar la nueva foto
            $fotoPath = $request->file('foto')->store('fotos', 'public');

            // Eliminar la foto anterior si existe
            if ($usuario->foto) {
                Storage::disk('public')->delete($usuario->foto);
            }

            $data['foto'] = $fotoPath;
        }

        $usuario->update($data);
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id) {
        $usuario = User::findOrFail($id);

        // Eliminar la foto del usuario si existe
        if ($usuario->foto) {
            Storage::disk('public')->delete($usuario->foto);
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}