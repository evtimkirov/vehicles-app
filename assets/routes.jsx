import VehiclesList from "./components/admin/VehiclesList";
import VehicleDetails from "./components/admin/VehicleDetails";
import CreateVehicle from "./components/admin/CreateVehicle";
import FollowedVehicles from "./components/admin/FollowedVehicles";
import Login from "./components/Login";
import Register from "./components/Register";
import ForgotPassword from "./components/ForgotPassword";

const routes = [
    {
        path: "/login",
        element: <Login />,
        isPrivate: false,
    },
    {
        path: "/register",
        element: <Register />,
        isPrivate: false,
    },
    {
        path: "/forgot-password",
        element: <ForgotPassword />,
        isPrivate: false,
    },
    {
        path: "/vehicles",
        element: <VehiclesList />,
        isPrivate: true,
    },
    {
        path: "/vehicles/create",
        element: <CreateVehicle />,
        isPrivate: true,
    },
    {
        path: "/vehicles/:id",
        element: <VehicleDetails />,
        isPrivate: true,
    },
    {
        path: "/vehicles/followed",
        element: <FollowedVehicles />,
        isPrivate: true,
    },
];

export default routes;
