import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Bewertung, Kriterien } from "@/stores/interfaces";


const api = new NetworkHelper();

export type State = {
    bewertung: Bewertung;
    krieterin: Kriterien[];
};

export const useUserStore = defineStore({
    id: "users",
    state: () =>
        ({
            bewertung: {} as Bewertung,
            krieterin: [] as Kriterien[],
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,

    },
    actions: {
        async getKriterien() {
            this.krieterin.splice(0);
            const krieterin =await api.get<Kriterien[]>("src/index.php/evaluation/getKriterien");  
            krieterin.forEach(k => this.krieterin.push(k));
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
