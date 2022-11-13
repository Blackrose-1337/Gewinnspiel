import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { User } from "@/stores/interfaces";
import { useQuasar } from "quasar";

const api = new NetworkHelper();
const $q = useQuasar();

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
                const answer= await api.get<User[]>("users");
                this.users.splice(0);

                answer.forEach(u => this.users.push(u));
                console.log(this.users);
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async getUsers(){
            this.users.splice;
          const users = await api.get<User[]>("src/index.php/user/list");
          users.forEach(u => this.users.push(u));
        },
        async posttest(u :User)
        {
            api.post<User>("src/index.php/user/list", u);   
        },
        async saveUserChange(u: User)
        {
            api.post<User>("src/index.php/admin/save", u);
        },

        async resetPW(userId:number) {
            try {
                const param =
                {
                    "userId": userId,
                }
                const info = await api.get<boolean>("src/index.php/admin/pwreset", param);
                return info;
            }catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        }
    },
});
