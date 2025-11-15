<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Preset;

class PresetRepository
{
    public function getList(array $filters = [])
    {
        $query = Preset::select('id', 'device_id', 'name', 'devices')
            ->search($filters)
            ->sort($filters)
            ->active();

        if (!empty($filters['limit'])) {
            $query->limit($filters['limit']);
        }

        return $query->get();
    }
}
