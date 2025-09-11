import React, { useEffect } from "react";
import { observer } from "mobx-react-lite";
import vehicleStore from "../../stores/VehicleStore";
import { Link } from "react-router-dom";

const VehiclesList = observer(() => {
    useEffect(() => {
        vehicleStore.fetchVehicles();
    }, []);

    if (vehicleStore.loading) return <p>Loading...</p>;
    if (vehicleStore.error) return <p style={{ color: "red" }}>{vehicleStore.error}</p>;

    return (
        <div>
            <h2>All Vehicles</h2>
            <ul>
                {vehicleStore.vehicles.map((v) => (
                    <li key={v.id}>
                        <Link to={`/vehicles/${v.id}`}>{v.name}</Link>
                    </li>
                ))}
            </ul>
        </div>
    );
});

export default VehiclesList;
