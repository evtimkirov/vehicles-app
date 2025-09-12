import React, {useEffect} from "react";
import { Link } from "react-router-dom";
import authStore from "../stores/AuthStore";

const AuthNavbar = () => {
    useEffect(() => {
        authStore.clearError();
    }, [location]);

    return (
        <nav style={{ marginBottom: "20px" }}>
            <Link to="/login" style={{ marginRight: "10px" }}>Login</Link>
            <Link to="/register" style={{ marginRight: "10px" }}>Register</Link>
            <Link to="/forgot-password">Forgot Password</Link>
        </nav>
    );
};

export default AuthNavbar;
