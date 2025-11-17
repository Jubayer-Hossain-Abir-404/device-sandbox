import { useCallback, useState, useRef } from "react";
import { useDrop } from "react-dnd";
import CanvasItem from "./CanvasItem";
import type { CanvasDevice, Device } from "@/types/device";

interface Position {
  x: number;
  y: number;
}

export default function Canvas() {
  const [items, setItems] = useState<CanvasDevice[]>([]);
  const canvasRef = useRef<HTMLDivElement>(null);

  const [, dropRef] = useDrop({
    accept: "DEVICE",
    drop: (data: Device, monitor) => {
      const clientOffset = monitor.getClientOffset();
      if (clientOffset && canvasRef.current) {
        const canvasRect = canvasRef.current.getBoundingClientRect();
        const relativePosition = {
          x: clientOffset.x - canvasRect.left,
          y: clientOffset.y - canvasRect.top,
        };
        addDeviceToCanvas(data, relativePosition);
      }
    },
  });

  const addDeviceToCanvas = useCallback(
    (devicePayload: Device, pos: Position) => {
      const id = `${String(devicePayload.id)}-${String(
        devicePayload.type
      )}-${String(Date.now())}`;

      const newItem: CanvasDevice = {
        id,
        type: devicePayload.type,
        meta: devicePayload.settings,
        x: pos.x,
        y: pos.y,
      };

      setItems((prevItems: CanvasDevice[]) => [...prevItems, newItem]);
    },
    []
  );

  const setRefs = useCallback(
    (el: HTMLDivElement) => {
      canvasRef.current = el;
      dropRef(el);
    },
    [dropRef]
  );

  return (
    <div
      ref={setRefs}
      className="h-[78vh] border rounded-lg bg-linear-to-br from-[#081222] to-[#0b1420] p-6 relative"
    >
      {items.length === 0 && (
        <div className="text-center mt-10">Drag a device here</div>
      )}

      {items.length > 0 && (
        <>
          {items.map((item) => (
            <CanvasItem key={item.id} item={item} />
          ))}
        </>
      )}
    </div>
  );
}
