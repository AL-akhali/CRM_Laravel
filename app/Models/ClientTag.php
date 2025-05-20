<?php

// app/Models/ClientTag.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ClientTag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color'];

    public static function booted(): void
    {
        static::creating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });

        static::updating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
