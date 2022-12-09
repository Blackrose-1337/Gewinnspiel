import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Competition, CompetitionDetails } from "@/stores/interfaces";
import { isNull } from "lodash";

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
        competition: {},
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async getCompetitiondeclarations() {
            try {
                let competitionDetails = await api.get<CompetitionDetails>("src/index.php/competition/competitionDetails");
                console.log(this.competitionDetails);
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
            const bool = api.post<boolean>("src/index.php/competition/competitionDetails", this.competitionDetails);
            return bool;
        },
        async postCompetition(c: Competition) {
            c.user.role = "teilnehmende";
            
            const bool = api.post<boolean>("src/index.php/competition/competition", c);   
            console.log(bool);
            return bool;
        
        }
    },
});
