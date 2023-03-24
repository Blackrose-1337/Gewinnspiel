import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Competition, CompetitionDetails, Project, User, ProjectBild } from "@/stores/interfaces";

const api = new NetworkHelper();

export type State = {
    competitionDetails: CompetitionDetails;
    competition: Competition;
};

export const useCompetitionStore = defineStore({
    id: "competition",
    state: () =>
        ({
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
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async postCompetitionDeclarations() {
            return api.post<number>("competition/competitionDetails", this.competitionDetails);
        },
        async postCompetition(c: Competition) {
            c.user.role = "teilnehmende";
            return api.post<number>("competition/competition", c);
        },
    },
});
