import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Bewertung, Kriterien } from "@/stores/interfaces";


const api = new NetworkHelper();

export type State = {
    bewertung: Bewertung[];
    kriterien: Kriterien[];
};

export const useEvaluationStore = defineStore({
    id: "evaluation",
    state: () =>
        ({
            bewertung: [] as Bewertung[],
            kriterien: [] as Kriterien[],
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,

    },
    actions: {
        async getKriterien() {
            this.kriterien.splice(0);
            const krieterin =await api.get<Kriterien[]>("src/index.php/evaluation/getKriterien");  
            krieterin.forEach(k => this.kriterien.push(k));
            
        },
        async postBewertung() {
            return api.post<boolean>("src/index.php/evaluation/createBewertung", this.bewertung);
        },
        async update(idProject: number) {
            this.bewertung.splice(0);
            this.kriterien.forEach(e =>
            {
                this.bewertung.push({
                    id: 0,
                    projectId: idProject,
                    kriterienId: e.id,
                    bewertung: e.value
                });
            })
            console.log(this.bewertung);
        },
    },
});
