import axios from "axios";

const api = axios.create({
    baseURL: "/api/v1/", // Include this before every API endpoint
});

// Add the interceptor
api.interceptors.request.use((config) => {
    const excludedPaths = ["/login", "/registration", "/forgot-password"];

    // Add the token for all the routes except the excluded ones
    if (!excludedPaths.some(path => config.url.includes(path))) {
        const token = localStorage.getItem("auth_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
    }

    return config;
}, (error) => {
    return Promise.reject(error);
});

export default api;
