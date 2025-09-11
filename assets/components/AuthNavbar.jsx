import React from "react";
import { Link } from "react-router-dom";

const AuthNavbar = () => {
    return (
        <nav style={{ marginBottom: "20px" }}>
            <Link to="/login" style={{ marginRight: "10px" }}>Login</Link>
            <Link to="/register" style={{ marginRight: "10px" }}>Register</Link>
            <Link to="/forgot-password">Forgot Password</Link>
        </nav>
    );
};

export default AuthNavbar;
