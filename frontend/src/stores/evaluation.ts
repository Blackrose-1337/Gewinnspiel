import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify } from "quasar";
import type { Auswertung, Bewertung, Kriterien, Message, Missing } from "@/stores/interfaces";
import { forEach } from "lodash";

const api = new NetworkHelper();

export type State = {
    bewertung: Bewertung[];
    kriterien: Kriterien[];
    img: string[];
    auswertung: Auswertung[];
    missing: Missing[];
};

export const useEvaluationStore = defineStore({
    id: "evaluation",
    state: () =>
        ({
            bewertung: [],
            kriterien: [],
            img: [],
            auswertungen: [],
            missing: [],
        } as State),
    getters: {},
    actions: {
        clear() {
            this.kriterien.forEach(k => {
                k.value = null;
            });
        },
        async getKriterien() {
            this.kriterien.splice(0);
            const krieterin = await api.get<Kriterien[]>("evaluation/getKriterien");
            krieterin.forEach(k => this.kriterien.push(k));
        },
        async postBewertung(idProject: number) {
            if (this.bewertung.length === 0) {
                this.kriterien.forEach(k => {
                    this.bewertung.push({
                        id: 0,
                        projectId: idProject,
                        kriterienId: k.id,
                        bewertung: k.value,
                        finish: 1,
                    });
                });
            } else {
                this.kriterien.forEach(k => {
                    this.bewertung.forEach(b => {
                        if (b.kriterienId == k.id) {
                            b.bewertung = k.value;
                            if (b.bewertung === 0 || b.bewertung === null) {
                                b.finish = 0;
                            } else {
                                b.finish = 1;
                            }
                        }
                    });
                });
                while (this.bewertung.length < this.kriterien.length) {
                    const neueBewertung = this.kriterien.find(
                        k => k.id !== this.bewertung.find(b => b.kriterienId === k.id)?.kriterienId
                    );
                    if (neueBewertung) {
                        if (neueBewertung.value === 0 || neueBewertung.value === null) {
                            this.bewertung.push({
                                id: 0,
                                projectId: idProject,
                                kriterienId: neueBewertung?.id,
                                bewertung: neueBewertung?.value,
                                finish: 0,
                            });
                        } else {
                            this.bewertung.push({
                                id: 0,
                                projectId: idProject,
                                kriterienId: neueBewertung.id,
                                bewertung: neueBewertung.value,
                                finish: 1,
                            });
                        }
                    }
                }
            }
            if (this.bewertung.length !== this.kriterien.length) {
                Notify.create({
                    message: "Es fehlen noch Bewertungen",
                    type: "warning",
                });
                return;
            } else if (this.bewertung.some(b => b.bewertung === null)) {
                Notify.create({
                    message: "Es fehlen noch Bewertungen",
                    type: "warning",
                });
                return;
            }

            return api.post<boolean>("evaluation/createBewertung", this.bewertung);
        },
        async getall(projectId: number) {
            this.clear();
            const param = {
                projectId: projectId,
            };
            function isBewertungArray(response: Bewertung[] | Message): response is Bewertung[] {
                return Array.isArray(response) && response.length > 0 && "projectId" in response[0];
            }

            const ans: Bewertung[] | Message = await api.get<Bewertung[] | Message>("evaluation/Bewertung", param);

            if (isBewertungArray(ans)) {
                this.bewertung.splice(0);
                ans.forEach(a => {
                    this.bewertung.push({
                        id: a.id,
                        projectId: a.projectId,
                        kriterienId: a.kriterienId,
                        bewertung: a.bewertung,
                        finish: a.finish,
                    });
                    this.kriterien.forEach(b => {
                        if (b.id == a.kriterienId) {
                            b.value = a.bewertung;
                        }
                    });
                });
            } else if (ans === 1) {
                return;
            } else {
                // Hier wird TypeScript wissen, dass ans eine Meldung ist.
                Notify.create({
                    message: ans.meldung,
                    type: "info",
                });

                //
                // const ans: Bewertung[] | Message = await api.get<Bewertung[] | Message>("evaluation/Bewertung", param);
                // if (ans.exists) {
                //     Notify.create({
                //         message: ans.meldung,
                //         type: "info",
                //     });
                // } else {
                //     this.bewertung.splice(0);
                //     ans.forEach(a => {
                //         this.bewertung.push({
                //             id: a.id,
                //             projectId: a.projectId,
                //             kriterienId: a.kriterienId,
                //             bewertung: a.bewertung,
                //             finish: a.finish,
                //         });
                //         this.kriterien.forEach(b => {
                //             if (b.id == a.kriterienId) {
                //                 b.value = a.bewertung;
                //             }
                //         });
                //     });
            }
        },
        async getmissing() {
            this.missing = await api.get("evaluation/bewertungsCheck");
            forEach(this.missing, value => {
                value.project_ids = value.project_ids.split(",");
            });
        },
        async getImages(id: number) {
            const param = {
                id: id,
            };
            this.img = [];
            const ans = await api.get<string[]>("evaluation/images", param);
            const host = import.meta.env.MODE === "production" ? "" : `http://localhost:8000/`;
            ans.pics.forEach(e => {
                e.img = host + e.img;
                this.img.push(e);
            });
            return this.img;
        },
        async getAnalysis() {
            this.auswertung = await api.get<Auswertung[]>("evaluation/analysis", null);
            this.auswertung.forEach(e => {
                e.value = +e.value;
            });
            return this.auswertung;
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
            }
            const ans = await api.post<boolean>("evaluation/createBewertung", this.bewertung);
            await this.getall(idProject);
            return ans;
        },
    },
});
