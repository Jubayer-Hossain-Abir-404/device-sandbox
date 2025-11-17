export type Device = {
  id: number
  type: number
  name: string
  settings: DeviceSettings
  status: boolean
}

export type DeviceSettings = {
    power: number
    color_temperatures?: DeviceColorTemperature
    brightness_percentage?: number
    speed_percentage?: number
}

export type DeviceColorTemperature = {
    warm: string
    neutral: string
    cool: string
    pink: string
}

export type CanvasDevice = {
  id: string
  type: number
  meta: DeviceSettings
  x: number | null
  y: number | null
}