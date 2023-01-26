import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
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
        clear() {
            this.kriterien.forEach((k) => {
                k.value = null;
            })
            console.log('kriterien:')
            console.log(this.kriterien)
        },
        async getKriterien() {
            this.kriterien.splice(0);
            const krieterin =await api.get<Kriterien[]>("evaluation/getKriterien");  
            krieterin.forEach(k => this.kriterien.push(k));
        },
        async postBewertung() {
            this.bewertung.forEach(b => {
                b.finish = 1;
            })
            return api.post<boolean>("evaluation/createBewertung", this.bewertung);
        },
        async getall(projectId: number) {
            this.clear();
            console.log(projectId);
            const param = {
                'projectId': projectId,
            }
            const ans = await api.get<Bewertung[]>("evaluation/Bewertung", param);
            if (ans.length == 0) {
                console.log('empty');
            } else {
                this.bewertung.splice(0);
                ans.forEach(a => {
                    this.bewertung.push({
                        id: a.id,
                        projectId: a.projectId,
                        kriterienId: a.kriterienId,
                        bewertung: a.bewertung,
                        finish: a.finish,
                    })                  
                    this.kriterien.forEach(b => {
                        if (b.id == a.kriterienId) {
                            b.value = a.bewertung;
                        }
                    })                    
                })             
            }
        },
        async update(idProject: number) {
            if (this.bewertung.length === 0) {
                this.kriterien.forEach(k => {
                    this.bewertung.push({
                        id: 0,
                        projectId: idProject,
                        kriterienId: k.id,
                        bewertung: k.value,
                        finish: 0,
                    });
                });
            } else {
                this.kriterien.forEach(k => {
                   
                    this.bewertung.forEach(b => {
                         console.log('k');
                        console.log(k.id);
                        console.log('b');
                        console.log(b.kriterienId)
                        if (b.kriterienId == k.id) {
                            b.bewertung = k.value;
                        }
                    });
                });
            };
            console.log(this.bewertung);
            const ans = await api.post<boolean>("evaluation/createBewertung", this.bewertung);
            this.getall(idProject);
            
        },
    },
});
