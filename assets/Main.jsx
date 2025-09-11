import React from "react";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import Login from "./components/Login";
import Register from "./components/Register";
import ForgotPassword from "./components/ForgotPassword";
import VehiclesList from "./components/admin/VehiclesList";
import VehicleDetails from "./components/admin/VehicleDetails";
import CreateVehicle from "./components/admin/CreateVehicle";
import FollowedVehicles from "./components/admin/FollowedVehicles";
import PrivateRoute from "./PrivateRoute";

const Main = () => {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Navigate to="/login" replace />} />
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/forgot-password" element={<ForgotPassword />} />

                {/* Protected routes */}
                <Route
                    path="/vehicles"
                    element={
                        <PrivateRoute>
                            <VehiclesList />
                        </PrivateRoute>
                    }
                />
                <Route
                    path="/vehicles/create"
                    element={
                        <PrivateRoute>
                            <CreateVehicle />
                        </PrivateRoute>
                    }
                />
                <Route
                    path="/vehicles/:id"
                    element={
                        <PrivateRoute>
                            <VehicleDetails />
                        </PrivateRoute>
                    }
                />
                <Route
                    path="/vehicles/followed"
                    element={
                        <PrivateRoute>
                            <FollowedVehicles />
                        </PrivateRoute>
                    }
                />

                <Route path="/" element={<Navigate to="/login" replace />} />
            </Routes>
        </Router>
    );
};

export default Main;
