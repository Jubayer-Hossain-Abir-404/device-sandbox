import type { Device } from '@/types/device'

export default function DeviceItem({ device }: { device: Device }) {
    return (
        <div
            className={`flex items-center gap-3 p-3 rounded-md border cursor-grab`}
            role="button"
            aria-pressed="false"
        >
            <div className="w-8 h-8 flex items-center justify-center bg-slate-800 rounded"> {/* icon */} </div>
            <div>{device.name}</div>
        </div>
    )
}
