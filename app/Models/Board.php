<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Str::uuid()->toString();
            }
        });
    }

    protected $fillable = [
        'name',
        'description',
        'status',
        'order',
        'user_id',
        'slug'
    ];

    public function cards()
    {
        return $this->hasMany(BoardCard::class, 'board_id', 'id');
    }
}
