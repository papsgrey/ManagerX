<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HSClient extends Model
{
    use HasFactory;

    protected $table = 'hs_clients';

    protected $fillable = [
        'hs_name',
        'ip_address',
        'um_server_id',
        'username',
        'password',
        'encrypted_password',
        'status',
    ];

    // Relationships
    public function server()
    {
        return $this->belongsTo(UMServer::class, 'um_server_id');
    }
}
