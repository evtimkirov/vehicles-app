export const extractError = (e, fallback = "Unexpected error") => {
    const data = e.response?.data;

    if (!data) return fallback;

    if (data.errors) {
        if (Array.isArray(data.errors)) return data.errors.join(", ");
        if (typeof data.errors === "object") return Object.values(data.errors).join(", ");
        return data.errors;
    }

    if (data.message) return data.message;

    return fallback;
};
