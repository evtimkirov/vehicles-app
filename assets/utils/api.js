import axios from "axios";

const api = axios.create({
    baseURL: "/api/v1/", // Include this before every API endpoint
});

// Add the interceptor
api.interceptors.request.use((config) => {
    const token = localStorage.getItem("auth_token");

    if (
        token &&
        !["login", "registration", "forgot-password"].some((endpoint) =>
            config.url.includes(endpoint)
        )
    ) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
});

export default api;
