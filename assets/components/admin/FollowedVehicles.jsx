import React, { useEffect } from "react";
import { observer } from "mobx-react-lite";
import vehicleStore from "../../stores/VehicleStore";

const FollowedVehicles = observer(() => {
    useEffect(() => {
        vehicleStore.fetchFollowedVehicles();
    }, []);

    if (vehicleStore.loading) return <p>Loading...</p>;
    if (vehicleStore.error) return <p style={{ color: "red" }}>{vehicleStore.error}</p>;

    return (
        <div>
            <h2>Followed Vehicles</h2>
            <ul>
                {vehicleStore.followed.map((v) => (
                    <li key={v.id}>{v.name}</li>
                ))}
            </ul>
        </div>
    );
});

export default FollowedVehicles;
