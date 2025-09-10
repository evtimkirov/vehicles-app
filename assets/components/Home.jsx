import React from "react";
import { observer } from "mobx-react-lite";
import counterStore from "../stores/CounterStore";

const Home = observer(() => {
    return (
        <div style={{ textAlign: "center", marginTop: "50px" }}>
            <h1>Welcome to Vehicles App</h1>
            <p>This is your home page.</p>

            <h2>Counter Example</h2>
            <p>Current value: {counterStore.count}</p>
            <button onClick={() => counterStore.increment()} style={{ marginRight: "5px" }}>+</button>
            <button onClick={() => counterStore.decrement()}>-</button>
        </div>
    );
});

export default Home;
