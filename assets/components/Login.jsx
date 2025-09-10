import React, { useState } from "react";
import { observer } from "mobx-react-lite";
import authStore from "../stores/AuthStore";

const Login = observer(() => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();

        authStore.login(email, password);
    };

    return (
        <div style={{ maxWidth: "400px", margin: "50px auto" }}>
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
