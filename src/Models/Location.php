<?php

namespace Dearpos\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
