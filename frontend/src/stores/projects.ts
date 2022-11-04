import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify } from "quasar";
import { HTTPError } from "ky";
import type { Project } from "@/stores/interfaces";

export type State = {
    projects: Project[];
    selectedProjectId: number | null;
};

export const useProjectStore = defineStore({
    id: "project",
    state: () =>
        ({
            projects: [],
            selectedProjectId: null,
        } as State),
    getters: {
        selectedProject: state => state.projects.find(p => p.id === state.selectedProjectId),
    },
    actions: {
        async fetchProjects() {
            const api = new NetworkHelper();
            try {
                this.projects = await api.get<Project[]>("projects");
            } catch (err) {
                this.projects = [];
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
