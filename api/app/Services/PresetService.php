<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\PresetRequest;
use App\Models\Preset;
use Illuminate\Http\Response as Res;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class PresetService
{
    public function save(PresetRequest $request): Preset
    {
        try {
            $preset = new Preset();
            $data = $request->only($preset->getFillable());
            $preset->fill($data)->save();

            return $preset;
        } catch (\Exception $e) {
            throw new InternalErrorException('Internal Server Error', Res::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
