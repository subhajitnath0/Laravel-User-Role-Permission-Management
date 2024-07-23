<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\Roles;


class Permission extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'permission_id';
    protected $table = 'permission';
    protected $fillable = [
        'permission_name',
        'permission_description',
    ];


}
