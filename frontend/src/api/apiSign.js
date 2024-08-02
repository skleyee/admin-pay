import axios from 'axios';
import store from '@/store';
import CryptoJS from 'crypto-js';

const apiSign = axios.create({
    baseURL: 'http://localhost:8000/api',
});

const apiKey = "apikey";
const secret = "abc123";

apiSign.interceptors.request.use(
    (config) => {
        const token = store.getters.authToken;
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        const data = config.data ? JSON.parse(JSON.stringify(config.data)) : {};
        const asArray = Object.entries(data);
        const arrayNoObj = asArray.filter(([value]) => {
            return (typeof value !== 'object' || value === null);
        });
        const filtered = Object.fromEntries(arrayNoObj);
        const ordered = Object.keys(filtered).sort().reduce((obj, key) => {
            obj[key] = data[key];
            return obj;
        }, {});
        ordered.k = apiKey;
        const jsonString = JSON.stringify(ordered);
        const cleanJsonString = jsonString.replace(/\//g, '\\/');
        const signature = CryptoJS.HmacSHA256(cleanJsonString, secret).toString();

        config.headers['X-sign'] = signature;

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default apiSign;
