import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { User } from "@/stores/interfaces";

const api = new NetworkHelper();
export type State = {
    users: User[];
    user: User;
    tempUser: User;
};

export const useUserStore = defineStore({
    id: "users",
    state: () =>
        ({
            users: [],
            user: {} as User,
            tempUser: {} as User,
        } as State),
    actions: {
        async getUser(u: number) {
            try {
                const param = {
                    userId: u,
                };
                this.user = await api.get<User>("user/getUser", param);
                this.tempUser = {
                    ...this.user,
                };
            } catch (err) {
                console.error(err);
            }
        },
        async getUsers() {
            this.users.splice(0);
            const users = await api.get<User[]>("user/list");
            users.forEach(u => this.users.push(u));
        },
        async saveUserChange(u?: User) {
            if (typeof u === "undefined") {
                u = this.user;
            }
            try {
                if (JSON.stringify(u) === JSON.stringify(this.tempUser)) {
                    return 2;
                } else {
                    this.tempUser = {
                        ...u,
                    };
                    return await api.post<boolean>("admin/save", u);
                }
            } catch (err) {
                console.log(err);
                throw err;
            }
        },
        async remove(userId: number) {
            const param = {
                userId: userId,
            };
            return await api.post<boolean>("admin/remove", param);
        },

        async resetPW(userId: number) {
            try {
                const param = {
                    userId: userId,
                };
                const res = await api.get<boolean>("admin/pwreset", param);
                if (res) {
                    return res;
                } else {
                    Notify.create({
                        message: `Da ist etwas schiefgelaufen, melden Sie sich beim Administrator`,
                        type: "negative",
                    });
                }
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async setPW(email: string, password: string, optIn: boolean) {
            try {
                const param = {
                    email: email,
                    password: password,
                    optIn: optIn,
                };
                const res = await api.post<boolean>("admin/setpw", param);
                if (res) {
                    return res;
                } else {
                    Notify.create({
                        message: `Da ist etwas schiefgelaufen, melden Sie sich beim Administrator`,
                        type: "negative",
                    });
                }
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
