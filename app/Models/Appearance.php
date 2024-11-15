<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url_slug',
        'logo',
        'qr_image',
        'image',
        'profile_title',
        'bio',
        'theme',
        'custom',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
