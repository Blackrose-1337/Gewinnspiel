import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify } from "quasar";
import { HTTPError } from "ky";
import type { Project, User } from "@/stores/interfaces";

const api = new NetworkHelper();

export type State = {
    project: Project;
    projects: Project[];
    selectedProjectId: number | null;
};

export const useProjectStore = defineStore({
    id: "project",
    state: () =>
    ({
            project: {} as Project,
            projects: [] as Project[],
            selectedProjectId: null,
        } as State),
    getters: {
       // selectedProject: state => state.projects.find(p => p.id === state.selectedProjectId),
    },
    actions: {
        async getProject(userId: number) {
            try {
                const param = {
                    "userId": userId,
                }
                this.project = await api.get<Project>("src/index.php/project/take", param);
            }catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
