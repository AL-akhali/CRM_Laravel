<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'type',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
