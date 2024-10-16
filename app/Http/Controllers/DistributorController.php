<?php

namespace App\Http\Controllers;

use App\Models\CompanyType;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
{
    public function viewDistributor()
    {
        $admin = Auth::user();
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity'])->get();
        return view('pages.role_admin.distributor.distributor', compact('distributors', 'admin'));
    }

    public function detailDistributor($id)
    {
        $admin = Auth::user();
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity'])->find($id);
        return view('pages.role_admin.distributor.detail_distributor', compact('distributors', 'admin'));
    }

    public function addDistributor()
    {
        $admin = Auth::user();
        $company_type = CompanyType::all();
        $company_province = Province::all();
        $company_city = Regency::all();
        return view('pages.role_admin.distributor.add_distributor', data: compact('admin', 'company_type', 'company_province', 'company_city'));
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
            'company_email' => 'required|string|email|max:255|unique:distributor',
            'company_website' => 'required',
        ], [
            'company_type_id.required' => 'Pilih salah satu tipe perusahaan',
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_province_id.required' => 'Pilih salah satu provinsi',
            'company_city_id.required' => 'Pilih salah satu kota',
            'company_address.required' => 'Alamat wajib diisi',
            'company_phone.required' => 'No. Telepon wajib diisi',
            'company_email.required' => 'Email wajib diisi',
            'company_email.unique' => 'Email ini sudah terdaftar',
            'company_website.required' => 'Website perusahaan wajib diisi',
        ]);
        Distributor::create([
            'company_type_id' => $validated['company_type_id'],
            'company_name' => $validated['company_name'],
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
        $admin = Auth::user();
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity'])->find($id);
        $company_type = CompanyType::all();
        $company_province = Province::all();
        $company_city = Regency::all();
        return view('pages.role_admin.distributor.edit_distributor', compact('admin', 'distributors', 'company_type', 'company_province', 'company_city'));
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
