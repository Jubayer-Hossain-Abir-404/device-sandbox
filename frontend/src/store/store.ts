import { configureStore } from '@reduxjs/toolkit'
import devicesReducer from '@/features/devices/deviceSlice'
import presetsReducer from '@/features/presets/presetsSlice'

export const store = configureStore({
  reducer: {
    devices: devicesReducer,
    presets: presetsReducer,
  },
})

// Infer the RootState and AppDispatch types
export type RootState = ReturnType<typeof store.getState>
export type AppDispatch = typeof store.dispatch