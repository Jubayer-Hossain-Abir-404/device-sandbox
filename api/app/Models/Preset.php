<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preset extends Model
{
    use FilterTrait;
    use SoftDeletes;

    protected $fillable = [
        'device_id',
        'name',
        'devices',
        'status',
    ];

    protected $casts = [
        'devices' => 'array',
    ];

    protected $hidden = ['deleted_at'];
}
