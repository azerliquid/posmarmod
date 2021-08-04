<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    protected $table = 'shopping';
    protected $primaryKey = 'id_shopping';
    protected $fillable = ['id_invoice', 'id_product', 'price', 'qty', 'totals'];

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product', 'id_product');
    }
    
    public function products(Type $var = null)
    {
        return $this->hasOne(Product::class, 'id_product', 'id_product');
    }
}
