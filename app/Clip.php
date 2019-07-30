<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    protected $fillable = [
        'caption',
        'filename'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
