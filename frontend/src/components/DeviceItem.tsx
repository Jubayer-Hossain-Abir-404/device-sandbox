import type { Device } from "@/types/device";
import { useDrag } from "react-dnd";

interface DeviceItemProps {
  device: Device;
}

export default function DeviceItem({ device }: DeviceItemProps) {
  const collectedProps = useDrag(() => ({
    type: "DEVICE",
    item: { id: device.id, type: device.type, meta: device.settings },
    collect: (monitor) => ({
      isDragging: monitor.isDragging(),
      canDrag: monitor.canDrag(),
    }),
  }));

  const [props, drag] = collectedProps;

  return (
    <div
      ref={(el) => {
        drag(el);
      }}
      className={`flex items-center gap-3 p-3 rounded-md border cursor-grab  
            ${props.isDragging ? "opacity-50" : "opacity-100"}`}
      role="button"
      aria-pressed="false"
    >
      <div className="w-8 h-8 flex items-center justify-center bg-slate-800 rounded">
        {" "}
        {/* icon */}{" "}
      </div>
      <div>{device.name}</div>
    </div>
  );
}
