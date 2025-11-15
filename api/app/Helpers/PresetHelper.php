<?php

declare(strict_types=1);

namespace App\Helpers;

class PresetHelper
{
    public static function getLightConfigSubKeys(): array
    {
        return [
            'power',
            'color_temperature',
            'brightness_percentage',
        ];
    }

    public static function getFanConfigSubKeys(): array
    {
        return [
            'power',
            'speed_percentage',
        ];
    }

    public static function getColorTemperatures(): array
    {
        return [
            '#FFE5B4', // Warm
            '#F0F8FF', // Neutral
            '#87CEEB', // Cool
            '#FFB6C1', // Pink
        ];
    }
}
