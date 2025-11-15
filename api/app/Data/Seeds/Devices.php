<?php

declare(strict_types=1);

namespace App\Data\Seeds;

class Devices
{
    public static function get(): array
    {
        $now = now();

        return [
            [
                'type' => 1,
                'name' => 'Light',
                'settings' => json_encode([
                    'power' => 0,
                    'color_temperatures' => [
                        'warm' => '#FFE5B4',
                        'neutral' => '#F0F8FF',
                        'cool' => '#87CEEB',
                        'pink' => '#FFB6C1',
                    ],
                    'brightness_percentage' => 0,
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 2,
                'name' => 'Fan',
                'settings' => json_encode([
                    'power' => 0,
                    'speed_percentage' => 0,
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
