<script setup lang="ts">
import { ref } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import Formular from "@/components/Formular.vue";
import { useUserStore } from "@/stores/users";
import { useCompetitionStore } from "@/stores/competition";
import type { User, Project, Competiion, ProjectBild } from "@/stores/interfaces";

const $q = useQuasar();

const userstore = useUserStore();
const competitionstore = useCompetitionStore();

const bsp: string[] = [];
var bild = new Image();

const { competition, competitionDetails } = storeToRefs(competitionstore);
const { user } = storeToRefs(userstore);

const usermodel = ref() as User;
const projectmodel: Project = ref({
    id: 0,
    userId: 0,
    title: "",
    text: "",
}) as Project;
const projectpics: ProjectBild = [] as ProjectBild[];
const dialog = ref(false);
const filesPng = ref();

function changeUserModel(u: User) {
    usermodel.value = u;
}
function sendcompetition() {
    //clear von übertragungs Bilder falls noch von versuch zuvor befüllt
    competition.value.pics.splice(0);
    //abfrage ob Bilder hochgeladen wurden falls ja werden diese in Base64 konvertiert
    if (filesPng.value.length > 0) {
        for (let index = 0; index < filesPng.value.length; index++) {
            const element = filesPng.value[index];
            let file = element;
            let reader = new FileReader();
            reader.onloadend = function () {
                const bild: ProjectBild = {
                    id: 0,
                    projectId: 0,
                    bildbase: reader.result as string,
                };
                competition.value.pics.push(bild);
            };
            reader.readAsDataURL(file);
        }

        // Verzögerung das Bilder konvertiert werden können
        setTimeout(() => {
            sendcompetitionstep2();
        }, 500);
    } else {
        $q.notify({
            type: "negative",
            message: "Es Fehlen Bilder",
            color: "red",
        });
    }
}

async function sendcompetitionstep2() {
    if (!usermodel.value) {
        $q.notify({
            type: "negative",
            message: "Keine Angaben vorhanden!",
            color: "red",
        });
    } else if (usermodel.value.surname == "" || usermodel.value.surname == null) {
        $q.notify({
            type: "negative",
            message: "Der Nachname fehlt!",
            color: "red",
        });
    } else if (usermodel.value.name == "" || usermodel.value.name == null) {
        $q.notify({
            type: "negative",
            message: "Der Vorname fehlt!",
            color: "red",
        });
    } else if (projectmodel.value.text == "" || projectmodel.value.text == null) {
        $q.notify({
            type: "negative",
            message: "Der Vorname fehlt!",
            color: "red",
        });
    } else if (usermodel.value.email == "" || usermodel.value.email == null) {
        $q.notify({
            type: "negative",
            message: "Die E-Mail fehlt!",
            color: "red",
        });
    } else if (projectmodel.value.title == "" || projectmodel.value.title == null) {
        $q.notify({
            type: "negative",
            message: "Titel zum Projekt fehlt",
            color: "red",
        });
    } else if (projectmodel.value.text == "" || projectmodel.value.text == null) {
        $q.notify({
            type: "negative",
            message: "Beschreibungstext zum Projekt fehlt",
            color: "red",
        });
    } else if (!teilnahmebedingungenbestätigung.value) {
        $q.notify({
            type: "negative",
            message: "Teilnahmebedingungen wurden nicht bestätigt!",
            color: "red",
        });
    } else if (isValidEmail(usermodel.value.email) != true) {
        $q.notify({
            type: "negative",
            message: "Ungültige Mailadresse",
            color: "red",
        });
    } else {
        // while (projectpics.length != filesPng.value.length) {

        competition.value.project = projectmodel.value;
        competition.value.user = usermodel.value;

        const bool: boolean = await competitionstore.postCompetition(competition.value);
        if (bool) {
            dialog.value = true;
            $q.notify({
                type: "positiv",
                message: "Ihr Wettbewerbsteilnahme wurde versendet",
                color: "green",
            });
        } else {
            $q.notify({
                type: "negative",
                message: "Da ist was schieff gelaufen",
                color: "red",
            });
        }
    }
}
function datecheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    if (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    ) {
        console.log(currentDateWithFormat + " > " + competitionDetails.value.wettbewerbbeginn);
        console.log(currentDateWithFormat + " < " + competitionDetails.value.wettbewerbende);
        return true;
    } else {
        console.log(currentDateWithFormat + " > " + competitionDetails.value.wettbewerbbeginn);
        console.log(currentDateWithFormat + " < " + competitionDetails.value.wettbewerbende);
        return false;
    }
}

function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}

function checkFileSize(files: any) {
    return files.filter((file: any) => file.size < 2048);
}

function checkFileType(files: any) {
    return files.filter((file: any) => file.type === "image/png");
}

function onRejected(rejectedEntries: any) {
    $q.notify({
        type: "negative",
        message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
    });
}

const teilnahmebedingungenbestätigung = ref(false);

async function load() {
    await competitionstore.getCompetitiondeclarations();
}
load();
</script>

<template>
    <div v-if="datecheck()">
        <q-card flat>
            <q-card-section align="center" v-html="competitionDetails.title" />
        </q-card>
        <q-card flat>
            <q-card-section align="left" v-html="competitionDetails.text" />
        </q-card>
        <div class="row q-pa-md">
            <div class="col-4 textarea" style="max-width: 30%">
                <q-input
                    v-model="projectmodel.title"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    label="Titel zum Projekt *"
                />
                <q-input
                    v-model="projectmodel.text"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    label="Beschreibung zum Projekt *"
                    autogrow
                />
            </div>
            <div class="col-1"></div>
            <div class="place row col-7 q-gutter-md">
                <Formular @change:declarations="changeUserModel" />
                <q-file
                    class="picloader"
                    v-model="filesPng"
                    rounded
                    outlined
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    label="Filtered (png only) *"
                    multiple
                    :filter="checkFileType"
                    @rejected="onRejected"
                    counter
                />
                <q-checkbox
                    left-label
                    v-model="teilnahmebedingungenbestätigung"
                    label="Teilnahmebedingungen"
                    class="col-4"
                />
                <q-space />
                <q-btn label="Senden" color="green" @click="sendcompetition" class="col-3" />
            </div>
        </div>
        <div class="textarea">
            <h5>Teilnahmebedingungen</h5>
            <q-card flat>
                <q-card-section v-html="competitionDetails.teilnehmerbedingung" />
            </q-card>
        </div>
        <div>
            <q-dialog v-model="dialog" persistent>
                <q-card>
                    <q-card-section class="row items-center">
                        <span class="q-ml-sm">
                            Es wurde eine Bestätigungsmail an die Mailadresse {{ usermodel.email }} gesendet. Diese
                            enthält das Passwort mit dem Sie sich einloggen können nachdem Sie ihre Bestätigung getätigt
                            haben.
                        </span>
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Cancel" color="primary" v-close-popup />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </div>
    </div>
    <div v-else>
        <q-card flat align="center">
            <q-card-section v-html="competitionDetails.wettbewerbCloseText" />
        </q-card>
    </div>
</template>

<style scoped>
.picloader {
    padding-left: 8px;
}
.place {
    position: relative;
}
.textarea {
    padding: 15px;
    padding-left: 30px;
    border: 3px solid black;
    border-radius: 15px;
    margin: 10px;
}
h3 {
    text-shadow: 1px 1px 1px black, 1px -1px 1px black, -1px 1px 1px black, -1px -1px 1px black;
    color: #4967de46;
    font-weight: bold;
    text-align: center;
}
.wettbewerbtitle {
    color: aqua;
}
</style>
