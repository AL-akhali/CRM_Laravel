<?php

// app/Models/ClientNote.php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{

    use HasFactory;
    protected $fillable = [
        'client_id',
        'user_id',
        'content',
        'visibility',
    ];

    protected static function booted()
    {
        static::creating(function ($note) {
            if (empty($note->user_id)) {
                $note->user_id = auth()->id();
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
