import React, { useEffect } from "react";
import { observer } from "mobx-react-lite";
import { useParams } from "react-router-dom";
import vehicleStore from "../../stores/VehicleStore";

const VehicleDetails = observer(() => {
    const { id } = useParams();

    useEffect(() => {
        vehicleStore.fetchVehicle(id);
    }, [id]);

    if (vehicleStore.loading) return <p>Loading...</p>;
    if (vehicleStore.error) return <p style={{ color: "red" }}>{vehicleStore.error}</p>;

    const vehicle = vehicleStore.vehicle;

    if (!vehicle) return <p>Vehicle not found</p>;

    return (
        <div>
            <h2>{vehicle.brand}</h2>
            <ul>
                <li>
                    <ul>
                        <li>Model: {vehicle.model}</li>
                        <li>Price: {vehicle.price}</li>
                        <li>Quantity: {vehicle.quantity}</li>
                    </ul>
                </li>
            </ul>
            <button onClick={() => vehicleStore.followVehicle(vehicle.id)}>Follow</button>
            {vehicleStore.message && <p style={{ color: "green" }}>{vehicleStore.message}</p>}
        </div>
    );
});

export default VehicleDetails;
