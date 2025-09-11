const API_ROUTES = {
    AUTH: {
        LOGIN: "login",
        REGISTER: "registration",
        FORGOT_PASSWORD: "forgot-password",
        ROLE: "users/role"
    },
    VEHICLES: {
        LIST: "vehicles",
        DETAIL: (id) => `vehicles/${id}`,
        CREATE: "vehicles",
        FOLLOW: "users/vehicles/follow",
        UNFOLLOW: "users/vehicles/unfollow",
        FOLLOWED: "users/vehicles/followed",
    },
};

export default API_ROUTES;
