<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryLubricant;
use App\Models\SubCategoryLubricant;
use Illuminate\Support\Facades\Auth;

class SubCategoryLubricantController extends Controller
{
    public function viewSubCategoryLubricant()
    {
        $admin = Auth::user();
        $subCategoryLubricants = SubCategoryLubricant::with('categoryLubricant')->get();
        return view('pages.role_admin.subcategory_lubricant.subcategory_lub', compact('admin', 'subCategoryLubricants'));
    }

    public function addSubCategoryLubricant()
    {
        $admin = Auth::user();
        $categoryLubricants = CategoryLubricant::all();
        return view('pages.role_admin.subcategory_lubricant.add_subcategory_lub', compact('categoryLubricants', 'admin'));
    }
    public function saveSubCategoryLubricant(Request $request)
    {
        $validated = $request->validate(
            [
                'category_lubricant_id' => 'required',
                'sub_category_name' => 'required',
                'sub_category_description' => 'required',
            ],
            [
                'category_lubricant_id.required' => 'Kategori wajib dipilih salah satu',
                'sub_category_name.required' => 'Sub Kategori wajib diisi',
                'sub_category_description.required' => 'Deskripsi wajib diisi',
            ]
        );

        SubCategoryLubricant::create([
            'category_lubricant_id' => $validated['category_lubricant_id'],
            'sub_category_name' => $validated['sub_category_name'],
            'sub_category_description' => $validated['sub_category_description'],
        ]);
        return redirect()->route('admin.subcategory.index')->with('success', 'Berhasil menambahkan <strong style="color:green;">' . $validated['sub_category_name'] . '</strong> ke sub kategori');
    }
    public function editSubCategoryLubricant($id)
    {
        $admin = Auth::user();
        $subCategoryLubricants = SubCategoryLubricant::with('categoryLubricant')->find($id);
        $categoryLubricants = CategoryLubricant::all();
        return view('pages.role_admin.subcategory_lubricant.edit_subcategory_lub', compact('subCategoryLubricants', 'categoryLubricants', 'admin'));
    }

    public function updateSubCategoryLubricant(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'category_lubricant_id' => 'required',
                'sub_category_name' => 'required',
                'sub_category_description' => 'required',
            ],
            [
                'category_lubricant_id.required' => 'Kategori wajib dipilih salah satu',
                'sub_category_name.required' => 'Sub Kategori wajib diisi',
                'sub_category_description.required' => 'Deskripsi wajib diisi',
            ]
        );
        $subCategoryLubricants = SubCategoryLubricant::find($id);
        $subCategoryLubricants->update($validated);
        return redirect()->route('admin.subcategory.index')->with('success', 'Berhasil mengupdate data.');
    }
    public function deleteSubCategoryLubricant($id)
    {
        $subCategoryLubricants = SubCategoryLubricant::find($id);
        $subCategoryLubricants->delete();
        return redirect()->route('admin.subcategory.index')->with('success', 'Berhasil menghapus data.');
    }
}
