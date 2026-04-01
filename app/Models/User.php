<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'nomor_induk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_lengkap',
        'no_telp',
        'email',
        'password',
        'nomor_induk',
        'is_active',
        'google_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Kalau kamu pakai hashing manual, pastikan password di-hash saat save
    // (atau pakai mutator di bawah)
    public function setPasswordAttribute($value)
    {
        // kalau sudah hash, biarin
        if (\strlen($value) === 60 && str_starts_with($value, '$2y$')) {
            $this->attributes['password'] = $value;
            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    /** RELASI */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'id_user', 'id_role')
            ->withTimestamps();
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'id_user');
    }

    /** ====== ROLE AUTH HELPERS ====== */

    // hasRole('admin') atau hasRole(['admin','superadmin'])
    public function hasRole(string|array $role): bool
    {
        $roleNames = is_array($role) ? $role : [$role];

        return $this->roles()
            ->whereIn('nama', $roleNames)
            ->exists();
    }

    // alias yang sering kepakai
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }

    // assignRole('admin') / assignRole(['admin','verifikator'])
    public function assignRole(string|array $role): void
    {
        $roleNames = is_array($role) ? $role : [$role];

        $roleIds = Role::whereIn('nama', $roleNames)->pluck('id')->toArray();

        // attach tanpa duplikat
        $this->roles()->syncWithoutDetaching($roleIds);
    }

    // syncRoles(['admin','verifikator']) -> set sesuai itu saja
    public function syncRoles(string|array $roles): void
    {
        $roleIds = Role::whereIn('nama', is_array($roles) ? $roles : [$roles])->pluck('id')->toArray();
        $this->roles()->sync($roleIds);
    }

    // removeRole('admin')
    public function removeRole(string $role): void
    {
        $roleId = Role::where('nama', $role)->value('id');
        if ($roleId) {
            $this->roles()->detach($roleId);
        }
    }

    // opsional: cek aktif
    public function isActive(): bool
    {
        return $this->is_active === 'active';
    }

    public function gedung()
    {
        return $this->hasMany(Gedung::class,'id_user','nomor_induk');
    }
}
