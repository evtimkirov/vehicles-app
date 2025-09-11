import { makeAutoObservable } from "mobx";
import api from "../utils/api";
import API_ROUTES from "../routes/apiRoutes";

class AuthStore {
    user = null;
    loading = false;
    error = null;
    message = null;
    token = null;
    role = null;

    constructor() {
        makeAutoObservable(this);

        const token = localStorage.getItem("auth_token");
        if (token) {
            this.token = token;
            this.user = {};
            this.fetchRole();
        }
    }

    login = async (email, password) => {
        this.loading = true;
        this.error = null;
        this.token = null;
        this.message = null;

        try {
            const response = await api.post(
                API_ROUTES.AUTH.LOGIN,
                { email, password }
            );

            this.token = response.data.token;
            this.user = { email };

            localStorage.setItem("auth_token", response.data.token);

            await this.fetchRole();
        } catch (e) {
            this.error = e.response?.data?.message || "Invalid credentials";
            localStorage.removeItem("auth_token");
        } finally {
            this.loading = false;
        }
    };

    fetchRole = async () => {
        if (!this.token) return;

        try {
            const response = await api.get(API_ROUTES.AUTH.ROLE);

            if (this.user) {
                this.user.role = response.data.role;
            } else {
                this.user = { role: response.data.role };
            }
        } catch (e) {
            console.error("Error fetching role:", e);
        }
    };

    register = async (first_name, last_name, email, password) => {
        this.loading = true;
        this.error = null;
        this.message = null;

        try {
            const response = await api.post(
                API_ROUTES.AUTH.REGISTER,
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
        this.message = null;

        try {
            const response = await api.post(
                API_ROUTES.AUTH.FORGOT_PASSWORD,
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
        this.token = null;
        localStorage.removeItem("auth_token");
    };
}

export default new AuthStore();
