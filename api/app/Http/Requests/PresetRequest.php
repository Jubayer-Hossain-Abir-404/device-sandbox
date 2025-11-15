<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Helpers\PresetHelper;
use App\Models\Device;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PresetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'devices.light_config' => 'Device Light Configuration',
            'devices.light_config.power' => 'Device Light Configuration Power',
            'devices.light_config.color_temperature' => 'Device Light Configuration Color Temperatures',
            'devices.light_config.brightness_percentage' => 'Device Light Configuration Brightness Percentage',

            'devices.fan_config' => 'Device Fan Configuration',
            'devices.fan_config.power' => 'Device Fan Configuration Power',
            'devices.fan_config.speed_percentage' => 'Device Fan Configuration Speed Percentage',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        $deviceId = empty($request->device_id) || !is_int($request->device_id) ? 0 : $request->device_id;
        $device = Device::select('id', 'type')
            ->active()
            ->find($deviceId);

        return [
            'device_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($device) {
                    if (!empty($value) && empty($device)) {
                        $fail('The device id is invalid.');
                    }
                },
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('presets', 'name')->whereNull('deleted_at'),
            ],
            'devices' => [
                'required',
                'array',
                'bail',
                function ($attribute, $value, $fail) {
                    $this->validateAllowedKeys($value, $fail);
                },
            ],
            ...$this->getLightConfigRules($device),
            ...$this->getFanConfigRules($device),
            'status' => [Rule::in([1])],
        ];
    }

    private function validateAllowedKeys(array $value, $fail): void
    {
        $allowedKeys = ['fan_config', 'light_config'];
        $extraKeys = array_diff(array_keys($value), $allowedKeys);
        if (!empty($extraKeys)) {
            $extraKeysString = implode(', ', $extraKeys);
            $fail("The following keys are not allowed: $extraKeysString.");
        }
    }

    private function validateAllowedSubKeys(array $value, $fail, array $allowedKeys): void
    {
        $extraKeys = array_diff(array_keys($value), $allowedKeys);
        if (!empty($extraKeys)) {
            $extraKeysString = implode(', ', $extraKeys);
            $fail("The following keys are not allowed: $extraKeysString.");
        }
    }

    private function getLightConfigRules($device): array
    {
        $deviceType = $device->type ?? '';
        $isLight = $deviceType === config('common.device_types.light');

        return [
            'devices.light_config' => [
                Rule::requiredIf($isLight),
                Rule::prohibitedIf(!$isLight),
                'array',
                'bail',
                function ($attribute, $value, $fail) {
                    if (is_array($value)) {
                        $this->validateAllowedSubKeys($value, $fail, PresetHelper::getLightConfigSubKeys());
                    }
                },
            ],
            'devices.light_config.power' => [
                'required_with:devices.light_config',
                'integer',
                'between:0,1',
            ],
            'devices.light_config.color_temperature' => [
                'required_with:devices.light_config',
                'string',
                Rule::in(PresetHelper::getColorTemperatures()),
            ],
            'devices.light_config.brightness_percentage' => [
                'required_with:devices.light_config',
                'integer',
                'between:0,100',
            ],
        ];
    }

    private function getFanConfigRules($device): array
    {
        $deviceType = $device->type ?? '';
        $isFan = $deviceType === config('common.device_types.fan');

        return [
            'devices.fan_config' => [
                Rule::requiredIf($isFan),
                Rule::prohibitedIf(!$isFan),
                'array',
                'bail',
                function ($attribute, $value, $fail) {
                    if (is_array($value)) {
                        $this->validateAllowedSubKeys($value, $fail, PresetHelper::getFanConfigSubKeys());
                    }
                },
            ],
            'devices.fan_config.power' => [
                'required_with:devices.fan_config',
                'integer',
                'between:0,1',
            ],
            'devices.fan_config.speed_percentage' => [
                'required_with:devices.fan_config',
                'integer',
                'between:0,100',
            ],
        ];
    }
}
