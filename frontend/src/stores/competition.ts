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
        async getCompetitiondeclarations() {
            try {
                let competitionDetails = await api.get<CompetitionDetails>("competition/competitionDetails");
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
        async postCompetitiondeclatations() {
            const ans = api.post<number>("competition/competitionDetails", this.competitionDetails);
            return ans;
        },
        async postCompetition(c: Competition) {
            c.user.role = "teilnehmende";
            const bool = api.post<boolean>("competition/competition", c);   
            return bool;
        
        }
    },
});
