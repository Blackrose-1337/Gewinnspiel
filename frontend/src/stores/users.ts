import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { ValueRange } from "@/stores/interfaces";

const api = new NetworkHelper();

export type State = {
    valueranges: ValueRange[];
};

export const useValueStore = defineStore({
    id: "valueranges",
    state: () =>
        ({
            valueranges: [],
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async getValueRange() {
            try {
                const valueranges = await api.get<ValueRange[]>("valueranges");
                this.valueranges.splice(0);

                valueranges.forEach(u => this.valueranges.push(u));
                console.log(this.valueranges);
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
