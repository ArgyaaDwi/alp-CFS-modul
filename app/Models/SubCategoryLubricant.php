<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLubricant extends Model
{
    use HasFactory;
    protected $table = 'sub_category_lubricant';
    protected $guarded = ['id'];
    protected $fillable = ['sub_category_name', 'sub_category_description', 'sub_category_code', 'category_lubricant_id'];
    public static function booted() {
        static::creating(function ($subCategory) {
            $subCategory->sub_category_code = self::generateSubCategoryCode($subCategory->sub_category_name);
        });
        static::updating(function ($subCategory) {
            $subCategory->sub_category_code = self::generateSubCategoryCode($subCategory->sub_category_name);
        });
    }

    public static function generateSubCategoryCode($sub_category_name)
    {
        $prefix = strtoupper(substr($sub_category_name, 0, 3));
        $count = self::count() + 1;
        $year = date('y');
        return $prefix . '-' . $count . '-' . $year;
    }
    public function categoryLubricant()
    {
        return $this->belongsTo(CategoryLubricant::class, 'category_lubricant_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_lubricant_id', 'id');
    }
}
