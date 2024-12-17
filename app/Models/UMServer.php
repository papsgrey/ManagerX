<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UMServer extends Model
{
    use HasFactory;

    protected $table = 'bb_um_servers';

    protected $fillable = [
        'server_name',
        'ip_address',
        'username',
        'password',
        'encrypted_password',
        'status',
    ];

    // Relationships
    public function clients()
    {
        return $this->hasMany(UMClient::class, 'um_server_id');
    }

    public function profiles()
    {
        return $this->hasMany(UMProfile::class, 'um_server_id');
    }

    public function limits()
    {
        return $this->hasMany(UMLimit::class, 'um_server_id');
    }
}
