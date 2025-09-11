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

    const v = vehicleStore.vehicle;
    if (!v) return <p>Vehicle not found</p>;

    return (
        <div>
            <h2>{v.name}</h2>
            <p>{v.description}</p>
            <button onClick={() => vehicleStore.followVehicle(v.id)}>Follow</button>
            <button onClick={() => vehicleStore.unfollowVehicle(v.id)}>Unfollow</button>
            {vehicleStore.message && <p style={{ color: "green" }}>{vehicleStore.message}</p>}
        </div>
    );
});

export default VehicleDetails;
