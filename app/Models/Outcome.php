<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{   
    use HasFactory;

    protected $table = 'outcome';
    protected $primaryKey = 'id_outcome';
    protected $fillable = ['name', 'id_branch', 'cashier_name', 'price', 'qty', 'outcome'];

    public function branch()
    {
        return $this->hasOne(BranchStore::class, 'id_branch', 'id_branch');
    }
}
