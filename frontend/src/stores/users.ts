import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { User } from "@/stores/interfaces";

const api = new NetworkHelper();

export type State = {
    users: User[];
};

export const useUserStore = defineStore({
    id: "users",
    state: () =>
        ({
            users: [],
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async getUser() {
            try {
                const valueranges = await api.get<User[]>("users");
                this.users.splice(0);

                valueranges.forEach(u => this.users.push(u));
                console.log(this.users);
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
