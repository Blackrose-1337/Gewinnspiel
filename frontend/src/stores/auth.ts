import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";

const api = new NetworkHelper();

export type State = {
    isAuthenticated: boolean;
    user: null | { username: string };
    isInitialized: boolean;
};

export const useAuthStore = defineStore({
    id: "auth",
    state: () =>
        ({
            isAuthenticated: false,
            user: null,
            isInitialized: false,
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async login(username: string, password: string) {
            try {
                const res = await api.post<{ success: boolean; user: { username: string } }>("auth/login", {
                    username,
                    password,
                });

                this.user = res.user;
                this.isAuthenticated = true;
            } catch (err) {
                this.isAuthenticated = false;
                throw err;
            }
        },
        async logout() {
            try {
                await api.post("auth/logout", null, false);
                this.isAuthenticated = false;
            } catch (err) {
                console.error(err);
                throw err;
            }
        },
        /**
         * Tries to get the currently authenticated user.
         * If the user isn't authenticated, the call fails with status 401
         */
        async getCurrentUser() {
            try {
                //this.user = await api.get("");
                this.isAuthenticated = true;
            } catch (err) {
                this.isAuthenticated = false;
            }
        },
        async initialize() {
            await this.getCurrentUser();
            this.isInitialized = true;
        },
    },
});
