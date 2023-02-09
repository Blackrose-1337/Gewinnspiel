import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify } from "quasar";
import type { Bewertung, Kriterien, Auswertung } from "@/stores/interfaces";




const api = new NetworkHelper();

export type State = {
    bewertung: Bewertung[];
    kriterien: Kriterien[];
    img: string[];
    auswertung: Auswertung[];
};

export const useEvaluationStore = defineStore({
    id: "evaluation",
    state: () =>
        ({
            bewertung: [] as Bewertung[],
            kriterien: [] as Kriterien[],
            img: [] as string[],
            auswertung: [] as Auswertung[],
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,

    },
    actions: {
        clear() {
            this.kriterien.forEach((k) => {
                k.value = null;
            })
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
            const param = {
                'projectId': projectId,
            }
            const ans = await api.get<Bewertung[]>("evaluation/Bewertung", param);
            if (ans.length == 0) {
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
        async getImages(id: number) {
            const param = {
                'id': id,
            };
            this.img= [];
            const ans = await api.get<string[]>("evaluation/images", param);
            
            ans.pics.forEach(e => {
                this.img.push(e);
            });
            return this.img;
        },
        async getAnalysis() {
            const ans = await api.get<Auswertung[]>("evaluation/analysis", null);
            console.log(ans)
            this.auswertung = ans;
            this.auswertung.forEach(e => {
                e.value = +e.value
            });
            console.log(this.auswertung)
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
                        if (b.kriterienId == k.id) {
                            b.bewertung = k.value;
                        }
                    });
                });
            };
            const ans = await api.post<boolean>("evaluation/createBewertung", this.bewertung);
            this.getall(idProject);
            
        },
    },
});
