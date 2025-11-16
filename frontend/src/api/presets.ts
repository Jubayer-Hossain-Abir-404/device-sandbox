import api from ".";
import type { Preset } from "@/types/preset";

export const getPresetList = async (): Promise<Preset[]> => {
  try {
    const response = await api.get("/api/v1/preset/list");
    return response.data.data;
  } catch (error) {
    throw new Error(
      `Failed to fetch presets: ${
        error instanceof Error ? error.message : "Unknown error"
      }`
    );
  }
};
