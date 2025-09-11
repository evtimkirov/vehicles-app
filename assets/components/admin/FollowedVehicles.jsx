import React, { useEffect } from "react";
import { observer } from "mobx-react-lite";
import vehicleStore from "../../stores/VehicleStore";
import {useNavigate} from "react-router-dom";

const FollowedVehicles = observer(() => {
    const navigate = useNavigate();

    useEffect(() => {
        vehicleStore.fetchFollowedVehicles();
    }, []);

    const handleUnfollow = async (id) => {
        await vehicleStore.unfollowVehicle(id);
        // след успешно unfollow редирект
        navigate("/vehicles/followed");
    };

    if (vehicleStore.loading) return <p>Loading...</p>;
    if (vehicleStore.error) return <p style={{ color: "red" }}>{vehicleStore.error}</p>;

    return (
        <div>
            <h2>Followed Vehicles</h2>
            <ul>
                {vehicleStore.followed.map((vehicle) => (
                    <li
                        key={vehicle.id}
                    >
                        {vehicle.brand} - {vehicle.model}
                        <button onClick={() => handleUnfollow(vehicle.id)}>Unfollow</button>
                    </li>
                ))}
            </ul>
        </div>
    );
});

export default FollowedVehicles;
