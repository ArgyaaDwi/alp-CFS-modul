<?php

namespace App\Http\Controllers;

use App\Models\CompanyType;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\MainDistributor;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
{
    public function viewDistributor()
    {
        $user = Auth::user();
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity', 'companyDistributor'])->get();
        return view('pages.role_admin.distributor.distributor', compact('distributors', 'user'));
    }

    public function detailDistributor($id)
    {
        $user = Auth::user();
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity'])->find($id);
        return view('pages.role_admin.distributor.detail_distributor', compact('distributors', 'user'));
    }

    public function addDistributor()
    {
        $user = Auth::user();
        $company_type = CompanyType::all();
        $company_province = Province::all();
        $company_city = Regency::all();
        $distributors = MainDistributor::all();
        return view('pages.role_admin.distributor.add_distributor', data: compact('user',  'company_type', 'company_province', 'company_city', 'distributors'));
    }
    public function saveDistributor(Request $request)
    {
        $validated =  $request->validate([
            'company_type_id' => 'required',
            'company_name' => 'required|string|max:255',
            'company_province_id' => 'required',
            'company_city_id' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|string|email|max:255|unique:distributors',
            'company_distributor_id' => 'required',
        ], [
            'company_type_id.required' => 'Pilih salah satu tipe perusahaan',
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_province_id.required' => 'Pilih salah satu provinsi',
            'company_city_id.required' => 'Pilih salah satu kota',
            'company_address.required' => 'Alamat wajib diisi',
            'company_phone.required' => 'No. Telepon wajib diisi',
            'company_email.required' => 'Email wajib diisi',
            'company_email.unique' => 'Email ini sudah terdaftar',
            'company_distributor_id.required' => 'Pilih salah satu main distributor',
        ]);
        Distributor::create([
            'company_type_id' => $validated['company_type_id'],
            'company_name' => $validated['company_name'],
            'company_distributor_id' => $validated['company_distributor_id'],
            'company_province_id' => $validated['company_province_id'],
            'company_city_id' => $validated['company_city_id'],
            'company_address' => $validated['company_address'],
            'company_phone' => $validated['company_phone'],
            'company_email' => $validated['company_email'],
            'company_website' => $validated['company_website']
        ]);
        return redirect()->route('admin.distributor.index')->with('success', 'Berhasil menambahkan <strong style="color:green;">' . $validated['company_name'] . '</strong> ke distributor');
    }
    public function editDistributor($id)
    {
        $user = Auth::user();
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity', 'companyDistributor'])->find($id);
        $company_type = CompanyType::all();
        $company_province = Province::all();
        $company_city = Regency::all();
        $companyDistributor = MainDistributor::all();
        return view('pages.role_admin.distributor.edit_distributor', compact('user', 'distributors', 'company_type', 'company_province', 'company_city', 'companyDistributor'));
    }

    public function updateDistributor(Request $request, $id)
    {
        $validated =  $request->validate([
            'company_type_id' => 'required',
            'company_name' => 'required|string|max:255',
            'company_province_id' => 'required',
            'company_city_id' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|string|email|max:255|unique:distributors,company_email,' . $id,
            'company_distributor_id' => 'required',
        ], [
            'company_type_id.required' => 'Pilih salah satu tipe perusahaan',
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_province_id.required' => 'Pilih salah satu provinsi',
            'company_city_id.required' => 'Pilih salah satu kota',
            'company_address.required' => 'Alamat wajib diisi',
            'company_phone.required' => 'No. Telepon wajib diisi',
            'company_email.required' => 'Email wajib diisi',
            'company_email.unique' => 'Email ini sudah terdaftar',
            'company_distributor_id.required' => 'Pilih salah satu main distributor',
        ]);
        $distributor = Distributor::find($id);
        $distributor->update([
            'company_type_id' => $validated['company_type_id'],
            'company_name' => $validated['company_name'],
            'company_distributor_id' => $validated['company_distributor_id'],
            'company_province_id' => $validated['company_province_id'],
            'company_city_id' => $validated['company_city_id'],
            'company_address' => $validated['company_address'],
            'company_phone' => $validated['company_phone'],
            'company_email' => $validated['company_email'],
            'company_website' => $request->company_website ?? null
        ]);
        return redirect()->route('admin.distributor.index')->with('success', 'Berhasil mengubah <strong style="color:green;">' . $validated['company_name'] . '</strong> distributor');
    }
    public function deleteDistributor($id)
    {
        $distributor = Distributor::where('id', $id)->first();
        if (!$distributor) {
            return redirect()->route('admin.distributor.index')->with('error', 'Distributor tidak ditemukan.');
        }
        Distributor::where('id', $id)->delete();
        return redirect()->route('admin.distributor.index')->with('success', 'Berhasil menghapus <strong style="color:green;">' . e($distributor->company_name) . '</strong> dari distributor');
    }
}
