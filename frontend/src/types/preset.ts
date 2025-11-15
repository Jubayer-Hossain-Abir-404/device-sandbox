export type Preset = {
  id: number;
  device_id: number;
  name: string;
  devices: PresetDevice;
  status: boolean;
};

export type PresetDevice = {
  fan_config?: FanConfig;
  light_config?: LightConfig;
};

export type FanConfig = {
  power: number;
  speed_percentage: number;
};

export type LightConfig = {
  power: number;
  brightness_percentage: number;
  color_temperature: string;
};
