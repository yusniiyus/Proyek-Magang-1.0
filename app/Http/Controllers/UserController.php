<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar pengguna.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk menambah pengguna baru.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            // Validasi Role (Wajib dipilih: admin atau staff)
            'role' => ['required', 'in:admin,staff'], 
            'password' => [
                'required',
                'confirmed', 
                Password::min(8)
            ],
        ]);

        // 2. Simpan Data ke Database
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'], // <--- Simpan Role di sini
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('users.index')
                         ->with('toast_success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Pastikan email unik, kecuali milik user ini sendiri
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            // Validasi Role saat update
            'role' => ['required', 'in:admin,staff'],
            
            // Password opsional (nullable) saat edit
            'password' => [
                'nullable', 
                'confirmed', 
                Password::min(8)
            ],
        ]);

        // 2. Update Data Dasar
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role']; // <--- Update Role di sini

        // 3. Cek apakah ada password baru
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // 4. Simpan Perubahan
        $user->save();

        // 5. Redirect dengan pesan sukses
        return redirect()->route('users.index')
                         ->with('toast_success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Pengaman: Jangan biarkan admin menghapus akunnya sendiri yang sedang login
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                             ->with('toast_error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus pengguna
        $user->delete();

        return redirect()->route('users.index')
                         ->with('toast_success', 'Pengguna berhasil dihapus.');
    }
}