import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify, TouchSwipe } from "quasar";
import { HTTPError } from "ky";
import type { Project } from "@/stores/interfaces";

const api = new NetworkHelper();

export type State = {
    projects: Project[];
    project: Project;
   // selectedProjectId: number | null;
};

export const useProjectStore = defineStore({
    id: "projects",
    state: () =>
    ({
            projects: [],
            project: {} as Project,
            //selectedProjectId: null,
        } as State),
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
        async getProjects() {
            try {
                this.projects.splice(0);
                const projects = await api.get<Project[]>("src/index.php/project/takeAll");
                projects.forEach(p => this.projects.push(p));
            }catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async setProject(p: Project) {
            this.project = p;
        },
        async postProject() {
            
            // gezielter Fehler eingebaut
            //this.project.userId = 2342;
            
            //Daten werden an Backendgesendet
            const bool= api.post<boolean>("src/index.php/project/update", this.project);
            return bool;
        },
    },
});
