import axios from "axios";
import AuthStore from "../stores/AuthStore";

const api = axios.create({
    baseURL: "/api/v1/", // Include this before every API endpoint
});

/**
 * Add token to every API endpoint
 */
api.interceptors.request.use((config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
});

/**
 * Redirect to the login page if JWT token expired
 */
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Clear the store and the localStorage
            AuthStore.logout();

            // Redirect to login page
            window.location.href = "/login";
        }
        return Promise.reject(error);
    }
);

export default api;
