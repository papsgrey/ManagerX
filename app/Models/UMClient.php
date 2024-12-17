<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UMClient extends Model
{
    use HasFactory;

    protected $table = 'bb_um_clients'; 


    protected $fillable = [
        'client_name',
        'ip_address',
        'um_server_id',          // Foreign key reference to the UM server
        'um_server_ip_address',  // New column for the UM server's IP address
        'username',
        'password',
        'encrypted_password',
        'status',
    ];

    // Define the relationship to UMServer
    public function umServer()
    {
        return $this->belongsTo(UMServer::class, 'um_server_id', 'id'); // Assuming 'id' is the primary key in UMServer
    }
}