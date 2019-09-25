<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'website',
        'location',
        'user_id', // author
    ];


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
