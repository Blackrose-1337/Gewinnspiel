import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { HTTPError } from "ky";
import { Notify } from "quasar";
import type { Answer, Survey } from "@/stores/interfaces";

export interface State {
    surveyQuestions: Survey[];
    surveyTitle: string;
    answers: Answer[];
    submissionId: number;
}

const api = new NetworkHelper();

export const useSurveyStore = defineStore({
    id: "surveySubmission",
    state: () =>
        ({
            surveyQuestions: [],
            surveyTitle: "",
            submissionId: 0,
            values: [],
            answers: [],
        } as State),
    getters: {},
    actions: {
        async changeQuestion(newtitle: string, newtext: string, id: string) {
            const changes = { title: newtitle, text: newtext, id: id };
            await api.post("surveys/changeQuestion", changes);
        },
        async createQuestion(titel: string, text: string, typ: string) {
            const c = { title: titel, text: text, typ: typ };
            await api.post("surveys/setQuestion", c);
        },
        async delete(id: id) {
            const c = { id: id };
            await api.post("surveys/deleteQuestion", c);
        },

        async getSurvey() {
            try {
                const survey = await api.get(`surveys/abfrage`);

                const { title, questions } = survey;

                this.surveyTitle = title;
                this.surveyQuestions.splice(0);
                questions.forEach(vr => {
                    this.surveyQuestions.push(vr);
                });
                this.submissionId = survey.id;
            } catch (err) {
                console.error(err);
                if (err instanceof HTTPError) {
                    Notify.create({ message: `HTTP Error: ${err.message}`, type: "negative" });
                }
            }
        },
    },
});
