<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramItem extends Model
{
    protected $fillable = [
        'category',
        'name',
        'description',
        'order',
    ];

    public function checks()
    {
        return $this->hasMany(ProgramCheck::class);
    }

    public function notes()
    {
        return $this->hasMany(ProgramNote::class);
    }
}
