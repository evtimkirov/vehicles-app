import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./components/Login";
import Register from "./components/Register";
import ForgotPassword from "./components/ForgotPassword";
import VehiclesList from "./components/admin/VehiclesList";
import VehicleDetails from "./components/admin/VehicleDetails";
import CreateVehicle from "./components/admin/CreateVehicle";
import FollowedVehicles from "./components/admin/FollowedVehicles";

const Main = () => {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/forgot-password" element={<ForgotPassword />} />
                <Route path="/vehicles" element={<VehiclesList />} />
                <Route path="/vehicles/create" element={<CreateVehicle />} />
                <Route path="/vehicles/:id" element={<VehicleDetails />} />
                <Route path="/vehicles/followed" element={<FollowedVehicles />} />
            </Routes>
        </Router>
    );
};

export default Main;
