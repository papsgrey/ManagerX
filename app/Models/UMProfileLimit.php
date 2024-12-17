<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UMProfileLimit extends Model
{
    use HasFactory;

    protected $table = 'um_profilelimits';

    protected $fillable = [
        'profile_id',
        'limit_id',
        'um_server_id',
    ];

    // Relationships
    public function profile()
    {
        return $this->belongsTo(UMProfile::class, 'profile_id');
    }

    public function limit()
    {
        return $this->belongsTo(UMLimit::class, 'limit_id');
    }

    public function server()
    {
        return $this->belongsTo(UMServer::class, 'um_server_id');
    }
}
