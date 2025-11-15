import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { getDeviceList } from '@/api/devices'
import type { Device } from '@/types/device'

interface DevicesState {
  list: Device[]
  status: 'idle' | 'loading' | 'succeeded' | 'failed'
  error: string | null
}

export const getDevices = createAsyncThunk('devices/fetch', async (_, { rejectWithValue }) => {
  try {
    const response = await getDeviceList()
    return response
  } catch (error) {
    return rejectWithValue((error as Error).message)
  }
})

const initialState: DevicesState = {
  list: [],
  status: 'idle',
  error: null
}

const devicesSlice = createSlice({
  name: 'devices',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(getDevices.pending, (s) => { 
        s.status = 'loading'
        s.error = null
      })
      .addCase(getDevices.fulfilled, (s, a) => { 
        s.status = 'succeeded'
        s.list = a.payload
      })
      .addCase(getDevices.rejected, (s, a) => { 
        s.status = 'failed'
        s.error = a.error.message ?? 'Unknown error occurred'
      })
  }
})

export default devicesSlice.reducer