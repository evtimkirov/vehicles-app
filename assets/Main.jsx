import React from "react";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import PrivateRoute from "./PrivateRoute";
import routes from "./routes/routes";

const Main = () => {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Navigate to="/login" replace />} />
                {routes.map(({ path, element, isPrivate }) =>
                    isPrivate ? (
                        <Route
                            key={path}
                            path={path}
                            element={<PrivateRoute>{element}</PrivateRoute>}
                        />
                    ) : (
                        <Route key={path} path={path} element={element} />
                    )
                )}
                <Route path="*" element={<Navigate to="/login" replace />} />
            </Routes>
        </Router>
    );
};

export default Main;
