import React, {useEffect} from "react";
import {Link, useLocation} from "react-router-dom";
import authStore from "../stores/AuthStore";
import { observer } from "mobx-react-lite";

const InnerNavbar = observer(() => {
    if (!authStore.user) return null;

    const role = authStore.user.role;
    const location = useLocation();

    useEffect(() => {
        authStore.clearError();
    }, [location]);

    return (
        <nav style={{ padding: "10px", background: "#eee", marginBottom: "20px" }}>
            <Link to="/vehicles" style={{ marginRight: "10px" }}>All Vehicles</Link>

            {role === "ROLE_MERCHANT" && (
                <Link to="/vehicles/create" style={{ marginRight: "10px" }}>Create Vehicle</Link>
            )}

            <Link to="/vehicles/followed" style={{ marginRight: "10px" }}>Followed Vehicles</Link>

            <button onClick={() => {
                authStore.logout();

                window.location.href = "/login";
            }}>
                Logout
            </button>
        </nav>
    );
});

export default InnerNavbar;
