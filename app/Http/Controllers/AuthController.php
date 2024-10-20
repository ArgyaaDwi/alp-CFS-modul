<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\MainDistributor;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check() && Auth::user()->is_verified == 1) {
            return $this->redirectToDashboard();
        } elseif (Auth::check() && Auth::user()->is_verified == 0) {
            Session::flush();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');
        }
        $distributors = Distributor::all();
        return view('auth.login', compact('distributors'));
    }
    // public function login(Request $request)
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         if ($user->is_verified == 0) {
    //             Session::flush();
    //             Auth::logout();
    //             $request->session()->invalidate();
    //             $request->session()->regenerateToken();

    //             // Redirect ke halaman waiting atau login
    //             return redirect('/waiting')->with('error', 'Akun Anda belum diverifikasi!');
    //         }
    //         return $this->r
    //     }
    // }
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $loginData = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($loginData)) {
            $user = Auth::user();
            Session::put('user_id', $user->id);
            Session::put('role_id',  $user->name);
            Session::put('email',  $user->email);
            Session::put('no_telephone',  $user->no_telephone);
            Session::put('distributor_id',  $user->distributor_id);
            Session::put('role_id',  $user->role_id);

            if ($user->is_verified == 0) {
                return redirect('/waiting');
            }
            return $this->redirectToDashboard();
            // if ($user->role_id == 1) {
            //     if ($user->is_verified == 0) {
            //         return redirect('/waiting');
            //     } else {
            //         return redirect('/dashboard/user');
            //     }
            // } else if ($user->role_id == 2) {
            //     return redirect('/dashboard/admin');
            // } else if ($user->role_id == 3) {
            //     return redirect('/dashboard/qm');
            // } else if ($user->role_id == 4) {
            //     return redirect('/dashboard/fgm');
            // }
        } else {
            return redirect()->back()->withErrors('Email atau password yang anda masukkan tidak sesuai!')->withInput();
        }
    }

    public function register()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        $distributors = MainDistributor::all();

        return view('auth.register', compact('distributors'));
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'distributor_id' => 'required',
            'no_telephone' => 'required|string|max:15',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
            'distributor_id.required' => 'Distributor tidak boleh kosong.',
            'no_telephone.required' => 'No. Telepon tidak boleh kosong.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'distributor_id' => $request->distributor_id,
            'no_telephone' => $request->no_telephone,
        ]);
        // dd(vars: $user);
        return redirect('/dashboard/user')->with('success', 'Registrasi berhasil.');
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
    private function redirectToDashboard()
    {
        $user = Auth::user();
        if ($user->role_id == 1) {
            return redirect('/dashboard/sales');
        } else if ($user->role_id == 2) {
            return redirect('/dashboard/admin');
        } else if ($user->role_id == 3) {
            return redirect('/dashboard/qm');
        } else if ($user->role_id == 4) {
            return redirect('/dashboard/fgm');
        }
    }
}
