import { configureStore } from '@reduxjs/toolkit'
import devicesReducer from '@/features/devices/deviceSlice'
import presetsReducer from '@/features/presets/presetsSlice'

export default configureStore({
  reducer: {
    devices: devicesReducer,
    presets: presetsReducer,
  },
})