<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramCheck extends Model
{
    protected $fillable = [
        'user_id',
        'program_item_id',
        'checked_at',
        'note',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programItem()
    {
        return $this->belongsTo(ProgramItem::class);
    }
}
