import type { Device } from "@/types/device";
import api from ".";

export const getDeviceList = async (): Promise<Device[]> => {
  try {
    const response = await api.get("/api/v1/device/list");
    return response.data.data;
  } catch (error) {
    throw new Error(
      `Failed to fetch devices: ${
        error instanceof Error ? error.message : "Unknown error"
      }`
    );
  }
};
