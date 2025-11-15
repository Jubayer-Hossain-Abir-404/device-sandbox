<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use FilterTrait;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'settings',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    protected $hidden = ['deleted_at'];
}
