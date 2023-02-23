import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Notify } from "quasar";
import { HTTPError } from "ky";
import type { Project, User, ProjectBild } from "@/stores/interfaces";
import { partial } from "lodash";


const api = new NetworkHelper();

export type State = {
    projects: Project[];
    project: Project;
    user: User;
    newimage: ProjectBild[]
};

export const useProjectStore = defineStore({
    id: "projects",
    state: () =>
    ({
        projects: [],
        project: {} as Project,
        user: {} as User,
        newimage:[] as ProjectBild[],
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
        async projectremove($id : number) {
            const param = {
                "id": $id,
            }
            const a = await api.post<boolean>("project/delete", param);
            return a
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
        async postPicupload() {
            const bool= api.post<boolean>("project/update", this.project);
            return bool;
        },
        async postDeletePic() {
            const bool= api.post<boolean>("project/update", this.project);
            return bool;
        },
    },
});
