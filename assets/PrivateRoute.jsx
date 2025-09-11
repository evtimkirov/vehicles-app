import React from "react";
import { Navigate } from "react-router-dom";
import AuthStore from "./stores/AuthStore";

const PrivateRoute = ({ children }) => {
    const token = localStorage.getItem("auth_token");

    if (!AuthStore.user || !token) {
        return <Navigate to="/login" replace />;
    }

    return children;
};

export default PrivateRoute;
