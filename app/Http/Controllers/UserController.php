<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Distributor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function viewUser()
    {
        $admin = Auth::user();
        $users = User::with(['distributor', 'role'])->get();
        return view('pages.role_admin.user.user', compact('users', 'admin'));
    }
    public function detailUser($id)
    {
        $admin = Auth::user();
        $users = User::with(['distributor', 'role'])->find($id);
        return view('pages.role_admin.user.detail_user', compact('users', 'admin'));
    }
    public function addUser()
    {
        $roles = Role::all();
        $admin = Auth::user();
        $distributors = Distributor::all();
        return view('pages.role_admin.user.add_user', compact('admin', 'distributors', 'roles'));
    }
    public function saveUser(Request $request)
    {
        $validated =  $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required',
            'no_telephone' => 'required',
            'address' => 'required',
            'is_verified' => 'required',
            'is_active' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi minimal 6 karakter',
            'role_id.required' => 'Role wajib diisi',
            'no_telephone.required' => 'No. Telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'email.unique' => 'Email ini sudah terdaftar',
            'is_verified.required' => 'Pilih salah satu',
            'is_active.required' => 'Pilih salah satu',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);
        $distributorId = $request->distributor_id ?? null;
        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic')->store('profile_pic', 'public');
            $profile_pic_name = basename($profile_pic);
        } else {
            $profile_pic_name = null; // Jika tidak ada file yang diunggah
        }
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'distributor_id' => $distributorId,
            'profile_pic' => $profile_pic_name,
            'role_id' => $validated['role_id'],
            'no_telephone' => $validated['no_telephone'],
            'address' => $validated['address'],
            'is_verified' => $validated['is_verified'],
            'is_active' => $validated['is_active'],
        ]);
        return redirect()->route('admin.user.index')->with('success', 'Berhasil menambahkan <strong style="color:green;">' . $validated['name'] . '</strong> ke user');
    }
    public function editUser($id)
    {
        $admin = Auth::user();
        $users = User::with(['distributor', 'role'])->find($id);
        $roles = Role::all();
        $distributors = Distributor::all();
        return view('pages.role_admin.user.edit_user', compact('users', 'admin', 'distributors', 'roles'));
    }
    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required',
            'no_telephone' => 'required',
            'address' => 'required',
            'is_verified' => 'required',
            'is_active' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email ini sudah terdaftar',
            'role_id.required' => 'Role wajib diisi',
            'no_telephone.required' => 'No. Telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'is_verified.required' => 'Pilih salah satu',
            'is_active.required' => 'Pilih salah satu',
        ]);
        $distributorId = $request->distributor_id ?? null;
        $user = User::find($id);
        $password = $request->password ? bcrypt($request->password) : $user->password;
        User::where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'distributor_id' => $distributorId,
            'role_id' => $validated['role_id'],
            'no_telephone' => $validated['no_telephone'],
            'address' => $validated['address'],
            'is_verified' => $validated['is_verified'],
            'is_active' => $validated['is_active'],
            'password' => $password,
        ]);
        return redirect()->route('admin.user.index')->with('success', 'Berhasil mengupdate data.');
    }
    public function verificationUser($id)
    {
        $users = User::findOrFail($id);
        $users->is_verified = !$users->is_verified;
        $users->save();
        return redirect()->route('admin.user.index')->with('success', 'Berhasil memverifikasi user <strong style="color:green;">' . e($users->name) . '</strong>.');
    }
    // public function updateStatusUser(Request $request, $id)
    // {
    //     $users = User::findOrFail($id);
    //     $users->is_active = $request->input('status');
    //     $users->save();
    //     return redirect()->route('admin.user.index')
    //         ->with('success', 'Status <strong style="color:green;">' . e($users->name) . '</strong> berhasil diubah.');
    // }
    public function updateStatusUser(Request $request, $id)
    {
        $users = User::findOrFail($id);
        if ($users->is_active != $request->input('status')) {
            $users->is_active = $request->input('status');
            $users->save();
            return redirect()->route('admin.user.index')
                ->with('success', 'Status <strong style="color:green;">' . e($users->name) . '</strong> berhasil diubah.');
        }
        return redirect()->route('admin.user.index')
            ->with('info', 'Status <strong style="color:blue;">' . e($users->name) . '</strong> tidak berubah.');
    }


    public function deleteUser($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'User tidak ditemukan.');
        }
        User::where('id', $id)->delete();
        return redirect()->route('admin.user.index')->with('success', 'Berhasil menghapus <strong style="color:green;">' . e($user->name) . '</strong> dari user');
    }
}
