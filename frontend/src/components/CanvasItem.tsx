import { DeviceType } from "@/constants";
import type { CanvasDevice } from "@/types/device";
import type { CSSProperties } from "react";

interface CanvasItemProps {
  item: CanvasDevice;
}
export default function CanvasItem({ item }: CanvasItemProps) {
  const style: CSSProperties = {
    position: "absolute",
    left: item.x ? item.x : "50%",
    top: item.y ? item.y : "50%",
    transform: item.x ? "none" : "translate(-50%, -50%)",
  };

  return (
    <div style={style} className="w-40 h-40 flex items-center justify-center">
      {item.type === DeviceType.LIGHT ? (
        <div className="rounded-full w-36 h-36 bg-yellow-300/80 shadow-[0_0_40px_12px_rgba(255,200,60,0.16)] flex items-center justify-center">
          <div className="text-yellow-900">Light</div>
        </div>
      ) : (
        <div className="rounded-md w-36 h-36 bg-slate-700 flex items-center justify-center">
          Fan
        </div>
      )}
    </div>
  );
}
