// resources/js/services/api.js
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8001/api', // ajusta según tu backend Laravel
});

api.interceptors.request.use(config => {
  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
