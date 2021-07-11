<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $primaryKey = 'id_invoice';
    protected $fillable = ['invoice','queue','id_cashier','id_branch','cash','pay','cash_return'];

    
    public function shopping()
    {
        
        return $this->hasMany(Shopping::class,  'id_invoice','id_invoice');
    }
    public function cashier()
    {
        return $this->belongsTo(Employe::class,  'id_cashier', 'id_user');
    }
    public function branch()
    {
        return $this->belongsTo(BranchStore::class, 'id_branch', 'id_branch');
    }
}
