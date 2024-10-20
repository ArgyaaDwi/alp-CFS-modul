<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryLubricant;
use Illuminate\Support\Facades\Auth;


class CategoryLubricantController extends Controller
{
    public function viewCategoryLubricant()
    {
        $user = Auth::user();
        $categories = CategoryLubricant::all();
        return view('pages.role_admin.category_lubricant.category_lub', compact('user',   'categories'));
    }
    public function addCategoryLubricant()
    {
        $user = Auth::user();

        return view('pages.role_admin.category_lubricant.add_category_lub', compact('user'));
    }
    public function saveCategoryLubricant(Request $request)
    {
        $validated = $request->validate(
            [
                'category_name' => 'required',
                'category_description' => 'required',
            ],
            [
                'category_name.required' => 'Nama wajib diisi',
                'category_description.required' => 'Deskripsi wajib diisi',
            ]
        );
        CategoryLubricant::create([
            'category_name' => $validated['category_name'],
            'category_description' => $validated['category_description'],
        ]);
        return redirect()->route('admin.category.index')->with('success', 'Berhasil menambahkan <strong style="color:green;">' . $validated['category_name'] . '</strong> ke kategori');
    }
    public function editCategoryLubricant($id)
    {
        $user = Auth::user();
        $categories = CategoryLubricant::find($id);
        return view('pages.role_admin.category_lubricant.edit_category_lub', compact('user', var_names: 'categories'));
    }
    public function updateCategoryLubricant(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'category_name' => 'required',
                'category_description' => 'required',
            ],
            [
                'category_name.required' => 'Nama wajib diisi',
                'category_description.required' => 'Deskripsi wajib diisi',
            ]
        );
        $categories = CategoryLubricant::find($id);
        $categories->update($validated);
        return redirect()->route('admin.category.index')->with('success', 'Berhasil mengupdate data.');
    }

    public function deleteCategoryLubricant($id)
    {
        $categories = CategoryLubricant::where('id', $id)->first();
        if (!$categories) {
            return redirect()->route('admin.category.index')->with('error', 'Kategori tidak ditemukan.');
        }
        CategoryLubricant::where('id', $id)->delete();
        return redirect()->route('admin.category.index')->with('success', 'Berhasil menghapus <strong style="color:green;">' . e($categories->category_name) . '</strong> dari kategori');
    }
}
