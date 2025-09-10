import React, { useState } from "react";
import { observer } from "mobx-react-lite";
import authStore from "../stores/AuthStore";

const Register = observer(() => {
    const [firstName, setFirstName] = useState("");
    const [lastName, setLastName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();

        authStore.register(firstName, lastName, email, password);
    };

    return (
        <div style={{ maxWidth: "400px", margin: "50px auto" }}>
            <h2>Register</h2>
            {authStore.error && <p style={{ color: "red" }}>{authStore.error}</p>}
            {authStore.message && <p style={{ color: "green" }}>{authStore.message}</p>}
            <form onSubmit={handleSubmit}>
                <input
                    type="text"
                    placeholder="First Name"
                    value={firstName}
                    onChange={e => setFirstName(e.target.value)}
                    required
                />
                <input
                    type="text"
                    placeholder="Last Name"
                    value={lastName}
                    onChange={e => setLastName(e.target.value)}
                    required
                />
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
                    {authStore.loading ? "Loading..." : "Register"}
                </button>
            </form>
        </div>
    );
});

export default Register;
