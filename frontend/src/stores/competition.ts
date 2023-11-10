import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Competition, CompetitionDetails, Project, ProjectBild, User } from "@/stores/interfaces";

const api = new NetworkHelper();

export type State = {
    logo: string;
    bildbase: string;
    competitionDetails: CompetitionDetails;
    competition: Competition;
};

export const useCompetitionStore = defineStore({
    id: "competition",
    state: () =>
        ({
            logo: "",
            bildbase: "",
            competitionDetails: {},
            competition: {
                project: {} as Project,
                user: {} as User,
                pics: [] as ProjectBild[],
            },
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async getCompetitionDeclarations() {
            try {
                const competitionDetails = await api.get<CompetitionDetails>("competition/competitionDetails");
                competitionDetails.wettbewerbbeginn = competitionDetails.wettbewerbbeginn.replaceAll("-", "/");
                competitionDetails.wettbewerbende = competitionDetails.wettbewerbende.replaceAll("-", "/");
                this.competitionDetails = competitionDetails;
                this.competitionDetails.istEmailAktiv = competitionDetails.istEmailAktiv != 1;
                this.competitionDetails.istProjektLoeschenUserErlaubt =
                    competitionDetails.istProjektLoeschenUserErlaubt != 0;
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async postCompetitionDeclarations() {
            this.competitionDetails.istEmailAktiv = !this.competitionDetails.istEmailAktiv;
            return api.post<number>("competition/competitionDetails", this.competitionDetails);
        },
        async postCompetition(c: Competition) {
            c.user.role = "teilnehmende";
            return api.post<number>("competition/competition", c);
        },
        async postNewProject(c: Competition) {
            c.user.role = "teilnehmende";
            return api.post<number>("project/newProject", c);
        },

        async getLogo() {
            const host = import.meta.env.MODE === "production" ? "" : `http://localhost:8000/`;
            this.logo = host + (await api.get<string>("competition/logo"));
        },
        async getLogoFresh() {
            const host = import.meta.env.MODE === "production" ? "" : `http://localhost:8000/`;
            const timestamp: number = Date.now(); // Aktueller Zeitstempel in Millisekunden
            this.logo = `${host + (await api.get<string>("competition/logo"))}?timestamp=${timestamp}`;
        },
        async setLogo() {
            return api.post<number>("competition/logo", this.bildbase);
        },
    },
});
