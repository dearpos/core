<?php

namespace DearPOS\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitOfMeasure extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'units_of_measures';

    protected $fillable = [
        'code',
        'name',
    ];
}
