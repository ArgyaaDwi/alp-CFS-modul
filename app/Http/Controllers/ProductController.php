<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CategoryLubricant;
use App\Models\SubCategoryLubricant;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function viewProductLubricant()
    {
        $user = Auth::user();
        $products = Product::with(['categoryLubricant', 'subCategoryLubricant'])->get();
        return view('pages.role_admin.product.product', compact('user', 'products'));
    }

    public function addProductLubricant()
    {
        $user = Auth::user();
        $categoryLubricants = CategoryLubricant::all();
        $subCategoryLubricants = SubCategoryLubricant::all();
        return view('pages.role_admin.product.add_product', compact('user', 'categoryLubricants', 'subCategoryLubricants'));
    }
    public function saveProductLubricant(Request $request)
    {
        $validated = $request->validate(
            [
                'category_lubricant_id' => 'required',
                'sub_category_lubricant_id' => 'required',
                'product_name' => 'required',
                'product_description' => 'required',
                'product_price' => 'required',
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'category_lubricant_id.required' => 'Kategori wajib dipilih salah satu',
                'sub_category_lubricant_id.required' => 'Sub Kategori wajib dipilih salah satu',
                'product_name.required' => 'Nama wajib diisi',
                'product_description.required' => 'Deskripsi wajib diisi',
                'product_price.required' => 'Harga wajib diisi',
                'product_image.required' => 'Gambar wajib diisi',
                'product_image.image' => 'File harus berupa gambar',
                'product_image.mimes' => 'File harus berupa jpeg,png,jpg',
                'product_image.max' => 'File maksimal 2 MB',
            ]
        );

        $product_img = $request->file('product_image')->store('product_image', 'public');
        $image = basename($product_img);

        Product::create([
            'category_lubricant_id' => $validated['category_lubricant_id'],
            'sub_category_lubricant_id' => $validated['sub_category_lubricant_id'],
            'product_name' => $validated['product_name'],
            'product_description' => $validated['product_description'],
            'product_price' => $validated['product_price'],
            'product_image' => $image,
        ]);
        return redirect()->route('admin.product.index')->with('success', 'Berhasil menambahkan <strong style="color:green;">' . $validated['product_name'] . '</strong> ke produk   ');
    }
    public function getSubCategoryLubricant($categoryId)
    {
        $subCategories = SubCategoryLubricant::where('category_lubricant_id', $categoryId)->get();
        return response()->json($subCategories);
    }
    public function detailProductLubricant($id)
    {
        $user = Auth::user();
        $products = Product::with(['categoryLubricant', 'subCategoryLubricant'])->find($id);

        return view('pages.role_admin.product.detail_product', compact('user', 'products'));
    }

    public function editProductLubricant($id)
    {
        $user = Auth::user();
        $products = Product::with(['categoryLubricant', 'subCategoryLubricant'])->find($id);
        $categoryLubricants = CategoryLubricant::all();
        $subCategoryLubricants = SubCategoryLubricant::all();
        return view('pages.role_admin.product.edit_product', compact('user', 'products', 'categoryLubricants', 'subCategoryLubricants'));
    }
    public function updateProductLubricant(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'category_lubricant_id' => 'required',
                'sub_category_lubricant_id' => 'required',
                'product_name' => 'required',
                'product_description' => 'required',
                'product_price' => 'required',
                'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'category_lubricant_id.required' => 'Kategori wajib dipilih salah satu',
                'sub_category_lubricant_id.required' => 'Sub Kategori wajib dipilih salah satu',
                'product_name.required' => 'Nama wajib diisi',
                'product_description.required' => 'Deskripsi wajib diisi',
                'product_price.required' => 'Harga wajib diisi',
                // 'product_image.required' => 'Gambar wajib diisi',
                'product_image.image' => 'File harus berupa gambar',
                'product_image.mimes' => 'File harus berupa jpeg,png,jpg',
                'product_image.max' => 'File maksimal 2 MB',
            ]
        );
        $products = Product::find($id);
        if ($request->hasFile('product_image')) {
            $product_img = $request->file('product_image')->store('product_image', 'public');
            $image = basename($product_img);
        } else {
            $image = $products->product_image;
        }

        $products->update([
            'category_lubricant_id' => $validated['category_lubricant_id'],
            'sub_category_lubricant_id' => $validated['sub_category_lubricant_id'],
            'product_name' => $validated['product_name'],
            'product_description' => $validated['product_description'],
            'product_price' => $validated['product_price'],
            'product_image' => $image,
        ]);
        return redirect()->route('admin.product.index')->with('success', 'Berhasil mengupdate data.');
    }

    public function deleteProductLubricant($id)
    {
        $products = Product::where('id', $id)->first();
        if (!$products) {
            return redirect()->route('admin.product.index')->with('error', 'Produk tidak ditemukan.');
        }
        Product::where('id', $id)->delete();
        return redirect()->route('admin.product.index')->with('success', 'Berhasil menghapus <strong style="color:green;">' . e($products->product_name) . '</strong> dari produk');
    }
}
