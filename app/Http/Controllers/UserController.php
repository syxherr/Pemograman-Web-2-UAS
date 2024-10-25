<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function login(){
        return view('user.login');
    }

    public function dashboard(){
        return view('user.dashboard');
    }

    public function dashboardUser(){
        return view('dashboard.user');
    }

    public function votingpaslon(){
        return view('user.voting');
    }

    public function loginAuth(Request $request){
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Coba dapatkan pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika pengguna ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Buat session atau token autentikasi
            Auth::login($user);
            
            // Cek grup pengguna dan arahkan ke halaman yang sesuai
            if ($user->group == 'admin') {
                return redirect('dashboard');
            } elseif ($user->group == 'user') {
                return redirect()->route('user.dashboard');
            } else {
                return redirect('/user/login')->with('error', 'Grup pengguna tidak valid.');
            }
        }

        return redirect('/user/login')->with('error', 'Login gagal. Silakan coba lagi.');
    }

    public function register(){
        return view('user.register');
    }

    public function storeRegister(Request $request){
        $value = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'group' => 'user',
        ];

        User::create($value);
        return redirect('dashboard');
    }

    public function profile(){
        // Implementasikan sesuai kebutuhan
    }

    public function logout(){
        Auth::logout();
        return view('user.login');
    }

    // Fungsi untuk menampilkan semua user
    public function index(){
        $users = User::all();
        return view('user.index', compact('users'));
    }

    // Fungsi untuk menampilkan form edit user
    public function edit($id){
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    // Fungsi untuk mengupdate data user
    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('dashboard');
    }

    // Fungsi untuk menghapus user
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('dashboard');
    }
}
