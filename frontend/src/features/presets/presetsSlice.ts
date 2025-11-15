import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import type { Preset } from '@/types/preset'
import { getPresetList } from '@/api/presets'

interface PresetsState {
  list: Preset[]
  status: 'idle' | 'loading' | 'succeeded' | 'failed'
  error: string | null
}

export const getPresets = createAsyncThunk('presets/fetch', async (_, { rejectWithValue }) => {
  try {
    return await getPresetList()
  } catch (error) {
    return rejectWithValue((error as Error).message)
  }
})

const initialState: PresetsState = {
  list: [],
  status: 'idle',
  error: null
}

const presetSlice = createSlice({
  name: 'presets',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(getPresets.pending, (s) => { 
        s.status = 'loading'
        s.error = null
      })
      .addCase(getPresets.fulfilled, (s, a) => { 
        s.status = 'succeeded'
        s.list = a.payload 
      })
      .addCase(getPresets.rejected, (s, a) => { 
        s.status = 'failed'
        s.error = a.error.message ?? 'Unknown error occurred'
      })
  }
})

export default presetSlice.reducer