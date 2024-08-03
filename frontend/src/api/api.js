import axios from 'axios';
import store from '@/store';

const api = axios.create({
    baseURL: 'api',
});

api.interceptors.request.use(
    (config) => {
        const token = store.getters.authToken;
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default api;
