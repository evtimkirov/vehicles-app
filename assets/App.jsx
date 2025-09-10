import React from "react";
import { observer } from "mobx-react-lite";
import counterStore from "./stores/CounterStore";

const App = observer(() => (
    <div style={{ textAlign: "center", marginTop: "50px" }}>
        <h1>Counter with MobX</h1>
        <p>Value: {counterStore.count}</p>
        <button onClick={() => counterStore.increment()}>+</button>
        <button onClick={() => counterStore.decrement()}>-</button>
    </div>
));

export default App;
