import React, { useEffect } from "react";
import { observer } from "mobx-react-lite";
import vehicleStore from "../../stores/VehicleStore";
import {useNavigate} from "react-router-dom";
import InnerNavbar from "../InnerNavbar";

const FollowedVehicles = observer(() => {
    const navigate = useNavigate();

    useEffect(() => {
        vehicleStore.fetchFollowedVehicles();
    }, []);

    const handleUnfollow = async (id) => {
        await vehicleStore.unfollowVehicle(id);

        navigate("/vehicles/followed");
    };

    if (vehicleStore.loading) return <p>Loading...</p>;
    if (vehicleStore.error) return <p style={{ color: "red" }}>{vehicleStore.error}</p>;

    return (
        <div>
            <InnerNavbar />
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
