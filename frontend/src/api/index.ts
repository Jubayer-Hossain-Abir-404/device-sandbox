import axios from "axios";

const api = axios.create({
  baseURL: '',
  timeout: 8000,
})

export default api;