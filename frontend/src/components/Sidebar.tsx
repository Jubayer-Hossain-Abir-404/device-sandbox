import { useEffect } from 'react'
import { getDevices } from '@/features/devices/deviceSlice'
import DeviceItem from './DeviceItem'
import type { Device } from '@/types/device'
import { useAppDispatch, useAppSelector } from '@/store/hooks'

export default function Sidebar() {
    const dispatch = useAppDispatch()
    const devices = useAppSelector((s) => s.devices.list)
    const devicesStatus = useAppSelector(s => s.devices.status)

    useEffect(() => {
        if (devicesStatus === 'idle') {
            void dispatch(getDevices())
        }
    }, [dispatch, devicesStatus])

    return (
        <div className="flex flex-col gap-6">
            <section>
                <h3 className="text-sm mb-2">Devices</h3>
                <div className="space-y-2">
                    {devices.length === 0 ? (
                        <div className="text-xs text-slate-400">No devices</div>
                    ) : (
                        devices.map((dev: Device) => <DeviceItem key={dev.id} device={dev} />)
                    )}
                </div>
            </section>
        </div>
    )
}
