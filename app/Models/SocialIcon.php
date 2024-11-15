<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialIcon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url_slug',
        'icon',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
