import React, { useEffect } from "react";
import { observer } from "mobx-react-lite";
import vehicleStore from "../../stores/VehicleStore";
import { Link } from "react-router-dom";
import InnerNavbar from "../InnerNavbar";

const VehiclesList = observer(() => {
    useEffect(() => {
        vehicleStore.fetchVehicles();
    }, []);

    if (vehicleStore.loading) return <p>Loading...</p>;
    if (vehicleStore.error) return <p style={{ color: "red" }}>{vehicleStore.error}</p>;

    return (
        <div>
            <InnerNavbar />
            <h2>All Vehicles</h2>
            <ul>
                {vehicleStore.vehicles.map((vehicle) => (
                    <li key={vehicle.id}>
                        <Link to={`/vehicles/${vehicle.id}`}>{vehicle.name} {vehicle.model}</Link>
                    </li>
                ))}
            </ul>
        </div>
    );
});

export default VehiclesList;
