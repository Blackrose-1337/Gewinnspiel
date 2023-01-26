import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { User } from "@/stores/interfaces";


const api = new NetworkHelper();

export type State = {
    users: User[];
    user: User;
};

export const useUserStore = defineStore({
    id: "users",
    state: () =>
        ({
        users: [],
        user: {} as User,
        } as State),
    actions: {
        async getUser(u: number) {
            try {
                const param = {
                'userId': u
            }
            this.user = await api.get<User>("user/getUser", param);  
            } catch (err) {
                console.error(err);
            }
            
        },
        async getUsers(){
        this.users.splice(0);
          const users = await api.get<User[]>("user/list");
          users.forEach(u => this.users.push(u));
        },
        async saveUserChange(u: User)
        {
            try {
                const res = await api.post<{ success: boolean; error: string; u: User }>("admin/save", u);
                
                if (res?.success) {
                    return res.success;
                } else {
                    const answer = {
                        'success': "negative",
                        'error': res?.error,
                    }
                    return answer;
                }
            } catch (err) {
                throw err;
            }
        },

        async resetPW(userId:number) {
            try {
                const param =
                {
                    "userId": userId,
                }
                const res = await api.get<{ success: boolean; error: string; }>("admin/pwreset", param);
                console.log(res)
                if (res?.success) {
                    return res.success;
                } else {
                    const answer = {
                        'success': "negative",
                        'error': res?.error,
                    }
                    return answer;
                }
            }catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        }
    },
});
