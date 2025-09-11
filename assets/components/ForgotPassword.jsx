import React, { useState } from "react";
import { observer } from "mobx-react-lite";
import authStore from "../stores/AuthStore";
import AuthNavbar from "./AuthNavbar";

const ForgotPassword = observer(() => {
    const [email, setEmail] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        authStore.forgotPassword(email);
    };

    return (
        <div style={{ maxWidth: "400px", margin: "50px auto" }}>
            <AuthNavbar />
            <h2>Forgot Password</h2>
            {authStore.error && <p style={{ color: "red" }}>{authStore.error}</p>}
            {authStore.message && <p style={{ color: "green" }}>{authStore.message}</p>}
            <form onSubmit={handleSubmit}>
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={e => setEmail(e.target.value)}
                    required
                />
                <button type="submit" disabled={authStore.loading}>
                    {authStore.loading ? "Loading..." : "Send Reset Link"}
                </button>
            </form>
        </div>
    );
});

export default ForgotPassword;
