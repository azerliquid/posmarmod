<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    protected $table = 'categorys';
    protected $primaryKey = 'id_categorys';
    protected $fillable = ['categorys'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
