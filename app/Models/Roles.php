<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roles extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'role_id';
    protected $table = 'roles';
    protected $fillable = [
        'role',
        'description',
    ];
    
   
   
}
