import React from "react";
import { createRoot } from "react-dom/client";
import Main from './Main';
import "./styles/app.css";

const root = createRoot(document.getElementById("root"));
root.render(<Main />);
