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
                this.competitionDetails = await api.get<CompetitionDetails>("src/index.php/competition/competition");
                console.log(this.competitionDetails);
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async postCompetition(c: Competition) {
            c.user.role = "Teilnehmende";
            console.log(c);
            api.post<Competition>("src/index.php/competition/competition", c);   
        
        }
    },
});
