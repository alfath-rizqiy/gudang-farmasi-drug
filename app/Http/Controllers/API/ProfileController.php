<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $oldFoto = $user->foto;

        $user->nama = $request->nama;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = Str::uuid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/foto_profile', $fileName);

            $user->foto = $fileName;

            if ($oldFoto && $oldFoto !== 'default.jpg' && Storage::disk('public')->exists('foto_profile/'.$oldFoto)) {
                Storage::disk('public')->delete('foto_profile/'.$oldFoto);
            }
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}
