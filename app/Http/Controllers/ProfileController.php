<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
         $user = $request->user();

        // Validasi tambahan untuk foto
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->fill($request->safe()->except(['foto']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $oldFoto = $user->foto;

        // Cek apakah ada upload foto baru
        if ($request->hasFile('foto')) {
            // Simpan foto baru
            $file = $request->file('foto');
            $fileName = Str::uuid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/foto_profile', $fileName);

            $user->foto = $fileName; 
            }

            $user->save();

            // Hapus foto lama kalau ada, tapi jangan hapus default.jpg
            if ($request->hasFile('foto')
                && $oldFoto 
                && $oldFoto !== 'default.jpg' && Storage::disk('public')->exists('public/foto_profile/'.$oldFoto)) {
                Storage::disk('public')->delete('public/foto_profile/'.$oldFoto);
            }

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diupdate');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
