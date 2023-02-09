import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify } from "quasar";
import { HTTPError } from "ky";
import type { Project, User } from "@/stores/interfaces";


const api = new NetworkHelper();

export type State = {
    projects: Project[];
    project: Project;
    user: User;
};

export const useProjectStore = defineStore({
    id: "projects",
    state: () =>
    ({
            projects: [],
            project: {} as Project,
            user: {} as User,
        } as State),
    actions: {
        async getProject(userId: number) {
            try {
                const param = {
                    "userId": userId,
                }
                this.project = await api.get<Project>("project/take", param);
            }catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async clear() {
            if (this.project.pics) {
                this.project.pics.splice(0, 0);
            }
            
        },
        async getProjects() {
            try {
                const projects = await api.get<Project[]>("project/takeAll");
                this.projects.splice(0);
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
            const bool= api.post<boolean>("project/update", this.project);
            return bool;
        },
    },
});