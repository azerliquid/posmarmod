<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Unit;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $fillable = ['code_products', 'name_products', 'id_categorys', 'id_units', 'price'];

    public function categorys(){
        return $this->belongsTo(Category::class, 'id_categorys');
    }
    public function units(){
        return $this->belongsTo(Unit::class, 'id_units');
    }
}
