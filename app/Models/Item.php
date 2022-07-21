<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'shops_id',
        'departments_id',
    ];

    public function shop(): HasMany
    {
        return $this->hasMany(Shop::class, 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'id');
    }
}
