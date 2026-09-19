<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\validation\Rules\Password;

class UserController extends Controller
{
    // Request $request -> mengambil value data : bisa dari input atau url
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            //'nama input' => ['jenis validasi']
            'name' => ['required', 'min: 3'],
            //unique:;  table, field : data email tidak boleh duplikat
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'min: 8', 'max: 10', 'confirmed', Password::min(8)->max(10)->uncompromised()],
        ], [
            //teks err yang bakal muncul jika validasi gagal
            //'nama_input.jenis_validasi' => 'pesan'
            'name.required' => 'Nama Lengkap harus diisi',
            'name.min' => 'Nama Lengkap minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email harus diisi dengan yang belum terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 10 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan password yang diberikan',
        ]);

        //simpan data ke database melalui model
        $createAccount = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],

            //hash::make -> mengubah pw plain text menjadi karakter acak yang tidak bisa dibaca/
            //dikembalikan ke teks aslinya
            'password' => Hash::make($validatedData['password']),
        ]);
        //menentukan jika berhasil disimpan akan diarahkan ke halaman nama : redirect()->route()
        //mengirimkan session untuk notifikasi berhasil with nama, pesan
        return redirect()->route('login')->with('success', 'Berhasil membuat akun. Silahkan login');
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // untuk memproses auth ambil data selain _token, csrf (email & password aja)
        $auth =  $request->except(['_token']);
        // Auth::attempt
        // 1. cek pasangan email-pw benar atau salah
        // 2. jika benar, simpan data di session/ cookies web
        // 3. jika salah, tentukan aksi yang dilakukan


        // $checkAuth = Auth::attempt($auth);
        // if($checkAuth) {
        //     // bikin ulang id session
        //     $request->session()->regenerate();
        //     return redirect()->route('home')->with('success', 'Berhasil login');
        // } else {
        // // withInput() -> mengirimkan old (data inputan sebelumnya) ke halaman login
        //     return redirect()->route('login')->with('error', 'Email dan password salah. Coba lagi!')->withInput();
        // }

        if (Auth::attempt($validatedData)) {
            $request->session()->regenerate();

            if (Auth::user()->role == "admin") {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login sebagai admin!');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil Login!');
            }
        } else {
                return redirect()->route('login')->with('error', 'Email dan password salah, coba lagi!')->withInput();

            }
    }

    public function logout(Request $request) {
        Auth::logout();
        // memastikan semua session yg ada dibuat invalid/ dihapus
        $request->session()->invalidate();
        // bikin ulang token session baru
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Berhasil logout');
    }
}

