<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLubricant extends Model
{
    use HasFactory;
    protected $table = 'category_lubricant';
    protected $fillable = ['category_name', 'category_description', 'category_code'];
    protected $guarded = ['id'];
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->category_code = self::generateCategoryCode($category->category_name);
        });
        static::updating(function ($category) {
            $category->category_code = self::generateCategoryCode($category->category_name);
        });
    }
    public static function generateCategoryCode($category_name)
    {
        $prefix = strtoupper(substr($category_name, 0, 3));
        $count = self::count() + 1;
        $year = date('y');
        return $prefix . '-' . $count . '-' . $year;
    }
    public function subCategoryLubricants()
    {
        return $this->hasMany(SubCategoryLubricant::class, 'category_lubricant_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_lubricant_id', 'id');
    }

}
