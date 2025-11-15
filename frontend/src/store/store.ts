import { configureStore } from '@reduxjs/toolkit'
import devicesReducer from '@/features/devices/deviceSlice'

export const store = configureStore({
  reducer: {
    devices: devicesReducer,
  },
})

// Infer the RootState and AppDispatch types
export type RootState = ReturnType<typeof store.getState>
export type AppDispatch = typeof store.dispatch