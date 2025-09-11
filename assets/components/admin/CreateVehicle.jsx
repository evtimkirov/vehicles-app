import React, { useState } from "react";
import { observer } from "mobx-react-lite";
import vehicleStore from "../../stores/VehicleStore";

const VehicleForm = observer(() => {
    const [type, setType] = useState("Car");

    const [formData, setFormData] = useState({
        // Common fields
        brand: "",
        model: "",
        price: "",
        quantity: "",
        // Dynamic fields
        engine_capacity: "",
        colour: "",
        doors: "",
        category: "",
        load_capacity: "",
        axles: "",
        beds: "",
    });

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        await vehicleStore.createVehicle({
            type,
            ...formData,
        });
    };

    return (
        <div>
            <h2>Create Vehicle</h2>
            <form onSubmit={handleSubmit}>
                {/* Common fields */}
                <input
                    type="text"
                    name="brand"
                    placeholder="Brand"
                    value={formData.brand}
                    onChange={handleChange}
                    required
                />
                <input
                    type="text"
                    name="model"
                    placeholder="Model"
                    value={formData.model}
                    onChange={handleChange}
                    required
                />
                <input
                    type="number"
                    name="price"
                    placeholder="Price"
                    value={formData.price}
                    onChange={handleChange}
                    required
                />
                <input
                    type="number"
                    name="quantity"
                    placeholder="Quantity"
                    value={formData.quantity}
                    onChange={handleChange}
                    required
                />

                {/* Vehicle type */}
                <select value={type} onChange={(e) => setType(e.target.value)}>
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                    <option value="trailer">Trailer</option>
                    <option value="truck">Truck</option>
                </select>

                {/* Dynamic fields depend on their type */}
                {type === "Car" && (
                    <>
                        <input
                            type="number"
                            step="0.1"
                            name="engine_capacity"
                            placeholder="Engine Capacity"
                            value={formData.engine_capacity}
                            onChange={handleChange}
                        />
                        <input
                            type="text"
                            name="colour"
                            placeholder="Colour"
                            value={formData.colour}
                            onChange={handleChange}
                        />
                        <input
                            type="number"
                            name="doors"
                            placeholder="Doors"
                            value={formData.doors}
                            onChange={handleChange}
                        />
                        <input
                            type="text"
                            name="category"
                            placeholder="Category"
                            value={formData.category}
                            onChange={handleChange}
                        />
                    </>
                )}

                {type === "Motorcycle" && (
                    <>
                        <input
                            type="number"
                            step="0.1"
                            name="engine_capacity"
                            placeholder="Engine Capacity"
                            value={formData.engine_capacity}
                            onChange={handleChange}
                        />
                        <input
                            type="text"
                            name="colour"
                            placeholder="Colour"
                            value={formData.colour}
                            onChange={handleChange}
                        />
                    </>
                )}

                {type === "Trailer" && (
                    <>
                        <input
                            type="number"
                            name="load_capacity"
                            placeholder="Load Capacity"
                            value={formData.load_capacity}
                            onChange={handleChange}
                        />
                        <input
                            type="number"
                            name="axles"
                            placeholder="Axles"
                            value={formData.axles}
                            onChange={handleChange}
                        />
                    </>
                )}

                {type === "Truck" && (
                    <>
                        <input
                            type="number"
                            step="0.1"
                            name="engine_capacity"
                            placeholder="Engine Capacity"
                            value={formData.engine_capacity}
                            onChange={handleChange}
                        />
                        <input
                            type="text"
                            name="colour"
                            placeholder="Colour"
                            value={formData.colour}
                            onChange={handleChange}
                        />
                        <input
                            type="number"
                            name="beds"
                            placeholder="Beds"
                            value={formData.beds}
                            onChange={handleChange}
                        />
                    </>
                )}

                <button type="submit" disabled={vehicleStore.loading}>
                    {vehicleStore.loading ? "Saving..." : "Create Vehicle"}
                </button>
            </form>

            {vehicleStore.error && <p style={{ color: "red" }}>{vehicleStore.error}</p>}
            {vehicleStore.message && <p style={{ color: "green" }}>{vehicleStore.message}</p>}
        </div>
    );
});

export default VehicleForm;
