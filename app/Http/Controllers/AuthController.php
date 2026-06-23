<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ==========================================
    // BAGIAN AUTHENTICATION (LOGIN & LOGOUT)
    // ==========================================
    public function login() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['username' => 'Username atau password salah!']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==========================================
    // BAGIAN CRUD USER / ADMIN (MENGGUNAKAN MODAL)
    // ==========================================
    
    // Tampilkan data dengan pagination yang rapi (Sudah termasuk Modal Create & Edit di View-nya)
    public function index() {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('auth.index', compact('users'));
    }

    // Proses simpan user baru (Dari Modal Create)
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superadmin,admin',
            'loket' => 'nullable|string|max:50'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'loket' => $request->loket
        ]);

        return redirect()->route('users.index')->with('success', 'Berhasil menambahkan pengguna baru.');
    }

    // Proses update user (Dari Modal Edit)
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'role' => 'required|in:superadmin,admin',
            'loket' => 'nullable|string|max:50'
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'loket' => $request->loket
        ];

        // Jika password diisi, maka update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Proses hapus user (Dengan Konfirmasi SweetAlert)
    public function destroy($id) {
        $user = User::findOrFail($id);
        
        // Mencegah superadmin menghapus dirinya sendiri saat sedang login
        if ($user->id == Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}