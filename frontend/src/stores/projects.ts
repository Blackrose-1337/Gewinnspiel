import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { useQuasar, Notify } from "quasar";
import { HTTPError } from "ky";
import type { Project, User, ProjectBild } from "@/stores/interfaces";

const api = new NetworkHelper();
export type State = {
    projects: Project[];
    project: Project;
    tempProject: Project;
    user: User;
    newImage: ProjectBild[];
    tempImage: object[];
    pics: object[];
};

export const useProjectStore = defineStore({
    id: "projects",
    state: () =>
        ({
            projects: [],
            project: {} as Project,
            tempProject: {} as Project,
            user: {} as User,
            newImage: [] as ProjectBild[],
            tempImage: [],
            pics: [] as object[],
        } as State),
    actions: {
        async getProject(userId: number) {
            try {
                const host = import.meta.env.MODE === "production" ? "" : `http://localhost:8000/`;
                const param = {
                    userId: userId,
                };
                this.project = await api.get<Project>("project/take", param);
                if (this.project.pics) {
                    this.project.pics.forEach(e => {
                        e.img = host + e.img;
                    });
                    this.tempProject = {
                        ...this.project,
                    };
                } else {
                    Notify.create({
                        message: "Kein Projekt vorhanden",
                        type: "info",
                    });
                }
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async clearPics() {
            if (this.project.pics) {
                this.project.pics.splice(0, 0);
            }
        },
        async projectRemove($id: number) {
            const param = {
                id: $id,
            };
            return await api.post<boolean>("project/delete", param);
        },
        async getProjects() {
            try {
                const projects = await api.get<Project[]>("project/takeAll");
                this.projects.splice(0);
                projects.forEach(p => this.projects.push(p));
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async getProjectsEva() {
            try {
                const projects = await api.get<Project[]>("project/takeprojects");
                this.projects.splice(0);
                projects.forEach(p => this.projects.push(p));
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
        async setProject(p: Project) {
            this.project = p;
            this.tempProject = {
                ...p,
            };
            return 1;
        },
        async postProject() {
            if (JSON.stringify(this.project) === JSON.stringify(this.tempProject)) {
                return 2;
            } else {
                this.tempProject = {
                    ...this.project,
                };
                return api.post<boolean>("project/update", this.project);
            }
        },
        async postPicUpload() {
            if (this.newImage.length > 0) {
                return await api.post<boolean>("project/addPicture", this.newImage);
            } else {
                return 2;
            }
        },
        async deletePic(imgPath: string) {
            const value = {
                projectId: this.project.id,
                imgPath: imgPath,
            };
            const bool = await api.post<number>("project/deletePicture", value);
            if (bool == 1) {
                this.project.pics.forEach((e, index) => {
                    if (e.img.split("/")[4] === imgPath.split("/")[6]) {
                        this.project.pics.splice(index, 1);
                    }
                });
            }
            return bool;
        },
        async approvalPost() {
            return api.post<boolean>("project/approval", this.project.id);
        },
    },
});
