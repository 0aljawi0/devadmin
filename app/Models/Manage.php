<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Manage extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('read', 'add', 'update', 'delete');
    }
}
