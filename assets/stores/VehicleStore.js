import { makeAutoObservable } from "mobx";
import api from "../utils/api";

class VehicleStore {
    vehicles = [];
    vehicle = null;
    followed = [];
    loading = false;
    error = null;
    message = null;
    user = null;

    constructor() {
        makeAutoObservable(this);
    }

    // Get all vehicles
    fetchVehicles = async () => {
        this.loading = true;
        this.error = null;
        try {
            const response = await api.get("vehicles");

            this.vehicles = response.data.data ?? [];
        } catch (e) {
            this.error = e.response?.data?.message || "Error loading vehicles";
        } finally {
            this.loading = false;
        }
    };

    // Vehicle detail
    fetchVehicle = async (id) => {
        this.loading = true;
        this.error = null;
        try {
            const response = await api.get(`vehicles/${id}`);

            this.vehicle = response.data.data ?? null;
        } catch (e) {
            this.error = e.response?.data?.message || "Error loading vehicle";
        } finally {
            this.loading = false;
        }
    };

    // Create a new vehicle
    createVehicle = async (payload) => {
        this.loading = true;
        this.error = null;
        this.message = null;
        try {
            const response = await api.post("vehicles", payload);

            this.message = response.data.message ?? "Vehicle created successfully";

            this.vehicles.push(response.data.data);
        } catch (e) {
            this.error = e.response?.data?.message || "Error creating vehicle";
        } finally {
            this.loading = false;
        }
    };

    // Follow vehicle
    followVehicle = async (id) => {
        this.loading = true;
        this.error = null;
        try {
            await api.post("/api/v1/vehicles/follow", { id });

            this.message = "Vehicle followed successfully";

            await this.fetchFollowedVehicles();
        } catch (e) {
            this.error = e.response?.data?.message || "Error following vehicle";
        } finally {
            this.loading = false;
        }
    };

    // Unfollow vehicle
    unfollowVehicle = async (id) => {
        this.loading = true;
        this.error = null;
        try {
            await api.post("vehicles/unfollow", { id });

            this.message = "Vehicle unfollowed successfully";

            await this.fetchFollowedVehicles();
        } catch (e) {
            this.error = e.response?.data?.message || "Error unfollowing vehicle";
        } finally {
            this.loading = false;
        }
    };

    // Get all the followed vehicles
    fetchFollowedVehicles = async () => {
        this.loading = true;
        this.error = null;
        try {
            const response = await api.get("vehicles/followed");

            this.followed = response.data.data ?? [];
        } catch (e) {
            this.error = e.response?.data?.message || "Error loading followed vehicles";
        } finally {
            this.loading = false;
        }
    };
}

export default new VehicleStore();
