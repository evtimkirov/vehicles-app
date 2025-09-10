import { makeAutoObservable } from "mobx";
import axios from "axios";
import api from "../utils/api";

class AuthStore {
    user = null;
    loading = false;
    error = null;
    message = null;

    constructor() {
        makeAutoObservable(this);
    }

    login = async (email, password) => {
        this.loading = true;
        this.error = null;

        try {
            const response = await api.post(
                "login",
                { email, password }
            );

            localStorage.setItem("auth_token", response.data.token);
        } catch (e) {
            this.error = e.response?.data?.message || "Invalid credentials";
        } finally {
            this.loading = false;
        }
    };

    register = async (first_name, last_name, email, password) => {
        this.loading = true;
        this.error = null;

        try {
            const response = await api.post(
                "registration",
                {
                    first_name,
                    last_name,
                    email,
                    password,
                });

            this.message = response.data.message;
        } catch (e) {
            this.error = e.response?.data?.message || "Registration failed";
        } finally {
            this.loading = false;
        }
    };

    forgotPassword = async (email) => {
        this.loading = true;
        this.error = null;

        try {
            const response = await api.post(
                "forgot-password",
                { email }
            );

            this.message = response.data.message;
        } catch (e) {
            this.error = e.response?.data?.message || "Error sending reset link";
        } finally {
            this.loading = false;
        }
    };

    logout = () => {
        this.user = null;
    };
}

export default new AuthStore();
