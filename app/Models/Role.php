<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $fillable = [
        'nama',
    ];

    public function users()
    {
        // relasi many-to-many lewat tabel user_role
        return $this->belongsToMany(User::class, 'user_role', 'id_role', 'id_user')
            ->withTimestamps();
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'id_role');
    }
}
