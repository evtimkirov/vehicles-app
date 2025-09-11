import React, { useState, useEffect } from "react";
import { observer } from "mobx-react-lite";
import authStore from "../stores/AuthStore";
import { useNavigate } from "react-router-dom";
import AuthNavbar from "./AuthNavbar";

const Login = observer(() => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        await authStore.login(email, password);
    };

    useEffect(() => {
        if (authStore.user || localStorage.getItem("auth_token")) {
            navigate("/vehicles");
        }
    }, [authStore.user, navigate]);

    return (
        <div style={{ maxWidth: "400px", margin: "50px auto" }}>
            <AuthNavbar />
            <h2>Login</h2>
            {authStore.error && <p style={{ color: "red" }}>{authStore.error}</p>}
            <form onSubmit={handleSubmit}>
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={e => setEmail(e.target.value)}
                    required
                />
                <input
                    type="password"
                    placeholder="Password"
                    value={password}
                    onChange={e => setPassword(e.target.value)}
                    required
                />
                <button type="submit" disabled={authStore.loading}>
                    {authStore.loading ? "Loading..." : "Login"}
                </button>
            </form>
        </div>
    );
});

export default Login;
