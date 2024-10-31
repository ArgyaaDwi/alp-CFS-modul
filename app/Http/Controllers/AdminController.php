<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_admin.profile.profile', compact('user', 'currentDate'));
    }
    public function editProfile()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_admin.profile.edit_profile', compact('user', 'currentDate'));
    }
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telephone' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'no_telephone.required' => 'No. Telepon tidak boleh kosong.',
            'address.required' => 'Alamat tidak boleh kosong.',
            'name.max' => 'Nama tidak boleh melebihi 255 karakter.',
        ]);
        $user->update([
            'name' => $request->name,
            'no_telephone' => $request->no_telephone,
            'address' => $request->address,
        ]);
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
    public function changePassword()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_admin.profile.change_password', data: compact('user', 'currentDate'));
    }
}
