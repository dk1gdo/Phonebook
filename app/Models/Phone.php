<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'number',
        'subscriber_id',
        'type_phone_id',
    ];

    public function typePhone(): BelongsTo
    {
        return $this->belongsTo(TypePhone::class);
    }
    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

}
