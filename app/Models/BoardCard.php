<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'board_id'
    ];

    public function items()
    {
        return $this->hasMany(BoardCardItem::class, 'card_id', 'id');
    }
}
