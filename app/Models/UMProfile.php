<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UMProfile extends Model
{
    use HasFactory;

    protected $table = 'um_profiles';

    protected $fillable = [
        'profile_name',
        'download_limit',
        'upload_limit',
        'validity',
        'um_server_id',
    ];

    // Relationships
    public function server()
    {
        return $this->belongsTo(UMServer::class, 'um_server_id');
    }

    public function limits()
    {
        return $this->belongsToMany(UMLimit::class, 'um_profilelimits', 'profile_id', 'limit_id');
    }
}
