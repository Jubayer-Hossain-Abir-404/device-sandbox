<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Device;

class DeviceRepository
{
    public function getList(array $filters = [])
    {
        $query = Device::select('id', 'type', 'name', 'settings')
            ->search($filters)
            ->active()
            ->orderBy('id', 'asc');

        if (!empty($filters['limit'])) {
            $query->limit($filters['limit']);
        }

        return $query->get();
    }
}
