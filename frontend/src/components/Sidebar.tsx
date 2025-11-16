import { useEffect } from "react";
import { getDevices } from "@/features/devices/deviceSlice";
import DeviceItem from "./DeviceItem";
import type { Device } from "@/types/device";
import { useAppDispatch, useAppSelector } from "@/store/hooks";
import { getPresets } from "@/features/presets/presetsSlice";

export default function Sidebar() {
  const dispatch = useAppDispatch();
  const devices = useAppSelector((s) => s.devices.list);
  const devicesStatus = useAppSelector((s) => s.devices.status);

  const presets = useAppSelector((s) => s.presets.list);
  const presetsStatus = useAppSelector((s) => s.presets.status);

  useEffect(() => {
    if (devicesStatus === "idle") {
      void dispatch(getDevices());
    }
  }, [dispatch, devicesStatus]);

  useEffect(() => {
    if (presetsStatus === "idle") {
      void dispatch(getPresets());
    }
  }, [dispatch, presetsStatus]);

  return (
    <div className="flex flex-col gap-6">
      <section>
        <h3 className="text-sm mb-2">Devices</h3>
        {devicesStatus === "loading" ? (
          <div className="text-xs">Loading...</div>
        ) : (
          <div className="space-y-2">
            {devices.length === 0 ? (
              <div className="text-xs text-slate-400">No devices</div>
            ) : (
              devices.map((dev: Device) => (
                <DeviceItem key={dev.id} device={dev} />
              ))
            )}
          </div>
        )}
      </section>

      <section>
        <h3 className="text-sm mb-2">Saved Presets</h3>
        {presetsStatus === "loading" ? (
          <div className="text-xs">Loading...</div>
        ) : (
          <div className="space-y-2">
            {presets.length === 0 ? (
              <div className="text-xs text-slate-400 rounded-md border p-3">
                Nothing added yet
              </div>
            ) : (
              presets.map((p) => (
                <div key={p.id} className="rounded-md border p-3">
                  {p.name}
                </div>
              ))
            )}
          </div>
        )}
      </section>
    </div>
  );
}
