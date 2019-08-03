<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    protected $fillable = [
        'caption',
        'filename',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
