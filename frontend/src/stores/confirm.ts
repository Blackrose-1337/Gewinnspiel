import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import type { User } from "@/stores/interfaces";


const api = new NetworkHelper();

export type State = {
    user: User;
};

export const useConfirmStore = defineStore({
    id: "confirm",
    state: () =>
    ({           
            user: {} as User,
        } as State),
    actions: {
        
        async confirm(token: string) {
            try {
                const param = {
                    'token': token,
                };
                this.user = await api.get<User>("confirm/confirm", param);
            } catch (err) {
                
                throw err; 
            }
        },
    },
});
