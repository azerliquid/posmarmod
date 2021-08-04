<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BranchStore;

class Employe extends Model
{
    protected $table = 'employe';
    protected $primaryKey = 'id_employe';
    protected $fillable = ['name', 'nip', 'phone', 'id_branch'];

    public function branch()
    {
        return $this->belongsTo(BranchStore::class, 'id_branch','id_branch');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
