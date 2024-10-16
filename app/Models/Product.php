<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = ['id'];
    protected $fillable = ['product_name', 'product_code', 'product_description', 'product_image', 'category_lubricant_id', 'sub_category_lubricant_id', 'product_price'];

    public static function booted()
    {
        static::creating(function ($product) {
            // Saat produk dibuat pertama kali, product_code di-set dengan angka "01"
            $product->product_code = self::generateProductCode($product->product_name, '01');
        });

        static::updating(function ($product) {
            // Saat update, ambil kode angka dari produk sebelumnya dan tambahkan 1
            $current_code = $product->product_code;
            $parts = explode('-', $current_code);
            $alphabet_part = $parts[2]; // Ambil bagian alphabet (4 digit)
            $current_number = intval($parts[1]); // Ambil bagian angka

            // Tambah angka saat update
            $new_number = str_pad($current_number + 1, 2, '0', STR_PAD_LEFT); // Format jadi 2 digit
            $product->product_code = self::generateProductCode($product->product_name, $new_number, $alphabet_part);
        });
    }

    public static function generateProductCode($product_name, $number, $alphabet = null)
    {
        $prefix = strtoupper(substr($product_name, 0, 3));
        if (!$alphabet) {
            $alphabet = strtoupper(Str::random(4)); // 4 digit random alphabet
        }
        $year = date('y');
        return $prefix . '-' . $number . '-' . $alphabet . '-' . $year;
    }
    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d F Y H:i');
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d F Y H:i');
    }
    public function categoryLubricant()
    {
        return $this->belongsTo(CategoryLubricant::class, 'category_lubricant_id');
    }

    public function subCategoryLubricant()
    {
        return $this->belongsTo(SubCategoryLubricant::class, 'sub_category_lubricant_id');
    }
    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'product_id', 'id');
    }
}
