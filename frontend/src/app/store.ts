import { configureStore } from '@reduxjs/toolkit'
import devicesReducer from '@/features/devices/deviceSlice'

export default configureStore({
  reducer: {
    devices: devicesReducer,
  },
})