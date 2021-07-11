<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employe;

class BranchStore extends Model
{
    use HasFactory;

    protected $table = 'branchstore';
    protected $primaryKey = 'id_branch';
    protected $fillable = ['branch_name', 'phone', 'address',  'id_cashier', 'id_chef', 'id_chef2'];
    
    public function cashier()
    {
        return $this->hasMany(Employe::class, 'id_employe', 'id_cashier');
    }
    public function chef()
    {
        return $this->hasMany(Employe::class, 'id_employe', 'id_chef');
    }
    public function chef2()
    {
        return $this->hasMany(Employe::class, 'id_employe', 'id_chef2');
    }
}
