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
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'no_telephone.required' => 'No. Telepon tidak boleh kosong.',
            'address.required' => 'Alamat tidak boleh kosong.',
            'profile_pic.image' => 'File harus berupa gambar.',
            'profile_pic.max' => 'File terlalu besar.',
            'profile_pic.mimes' => 'File harus berupa jpeg, png, jpg.',
            'name.max' => 'Nama tidak boleh melebihi 255 karakter.',
        ]);
        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic')->store('profile_pic', 'public');
            $image = basename($profile_pic);
        } else {
            $image = $user->profile_pic;
        }
        $user->update([
            'name' => $request->name,
            'no_telephone' => $request->no_telephone,
            'address' => $request->address,
            'profile_pic' => $image,
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
