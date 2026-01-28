import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

export const getCsrfCookie = () => axios.get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true });

export const getStyles = () => api.get('/styles');
export const getStyle = (id: number) => api.get(`/styles/${id}`);
export const generateImage = (data: any) => api.post('/studio/generate', data);
export const pollImage = (id: number) => api.get(`/studio/poll/${id}`);
export const getBalance = () => api.get('/wallet/balance');
export const getHistory = () => api.get('/history');

export default api;
