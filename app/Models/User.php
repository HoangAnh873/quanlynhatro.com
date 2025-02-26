<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    public function host()
    {
        return $this->hasOne(Host::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }
}
