<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypePhone extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title',
    ];

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }
}
