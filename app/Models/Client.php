<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'email',
        'phone',
        'industry',
        'address',
        'status',
    ];

    protected $casts = [
        'type' => 'string',
        'status' => 'string',
    ];

    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }

    // app/Models/Client.php

    public function notes()
    {
        return $this->hasMany(ClientNote::class);
    }



    // العلاقات القادمة لاحقًا:
    // public function contacts()
    // {
    //     return $this->hasMany(ClientContact::class);
    // }

    // public function notes()
    // {
    //     return $this->hasMany(ClientNote::class);
    // }

    // public function activities()
    // {
    //     return $this->hasMany(ClientActivity::class);
    // }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class);
    // }
}
