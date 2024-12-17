<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UMLimit extends Model
{
    use HasFactory;

    protected $table = 'um_limits';

    protected $fillable = [
        'limit_name',
        'download_limit',
        'upload_limit',
        'um_server_id',
    ];

    // Relationships
    public function server()
    {
        return $this->belongsTo(UMServer::class, 'um_server_id');
    }

    public function profiles()
    {
        return $this->belongsToMany(UMProfile::class, 'um_profilelimits', 'limit_id', 'profile_id');
    }
}
