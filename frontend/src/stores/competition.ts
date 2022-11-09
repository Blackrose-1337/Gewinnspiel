import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Competition } from "@/stores/interfaces";
import { isNull } from "lodash";

const api = new NetworkHelper();

export type State = {
    competition: Competition;
};

export const useCompetitionStore = defineStore({
    id: "competition",
    state: () =>
        ({
            competition: {},
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async getCompetition() {
            try {
                this.competition = await api.get<Competition>("src/index.php/competition/competition");
                this.competition;
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
