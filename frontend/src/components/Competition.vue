<script setup lang="ts">
import { ref } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import Formular from "@/components/Formular.vue";
import { useCompetitionStore } from "@/stores/competition";
import type { User, Project, ProjectBild } from "@/stores/interfaces";
import Loading from "vue-loading-overlay";

//--------------- Storeload ------------------------------
const $q = useQuasar();
const competitionstore = useCompetitionStore();

//--------------- variables ------------------------------
const usermodel = ref({
    id: 0,
    name: "",
    surname: "",
    role: "",
    email: "",
    land: "",
    plz: null,
    ortschaft: "",
    str: "",
    strNr: null,
    vorwahl: "",
    tel: null,
}) as User;
const projectmodel: Project = ref({
    id: 0,
    userId: 0,
    title: "",
    text: "",
}) as Project;
const dialog = ref(false);
const filesPng = ref();
const teilnahmebedingungenbestaetigung = ref(false);
let isLoading = ref(false);
const fullPage = ref(true);
const fileRef = ref(null);
const textRef = ref(null);
const titleRef = ref(null);
const checkRef = ref(null);
const addressFormRef = ref(null);

//--------------- storeToRefs ------------------------------
const { competition, competitionDetails } = storeToRefs(competitionstore);

//--------------- computed ------------------------------

//--------------- funcions ------------------------------
function remove(file: object) {
    filesPng.value.splice(filesPng.value.indexOf(file), 1);
}

function changeUserModel(u: User) {
    usermodel.value = u;
}

async function sendcompetition() {
    const errMessage = await validate1();
    //clear von übertragungs Bilder falls noch von versuch zuvor befüllt
    competition.value.pics.splice(0);
    //abfrage ob Bilder hochgeladen wurden falls ja werden diese in Base64 konvertiert

    if (errMessage.length === 0) {
        for (let index = 0; index < filesPng.value.length; index++) {
            let file = filesPng.value[index];
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
        setTimeout(async () => {
            competition.value.project = projectmodel.value;
            competition.value.user = usermodel.value;
            isLoading.value = true;
            const ans = await competitionstore.postCompetition(competition.value);
            if (ans == 1) {
                isLoading.value = false;
                dialog.value = true;
                $q.notify({
                    type: "positiv",
                    message: "Ihr Wettbewerbsteilnahme wurde versendet",
                    color: "green",
                });
            } else if (ans == 2) {
                isLoading.value = false;
                $q.notify({
                    type: "negative",
                    message: "Sie haben bereits am Wettbewerb teilgenommen",
                    color: "red",
                });
            } else {
                isLoading.value = false;
                $q.notify({
                    type: "negative",
                    message: "Da ist was schieff gelaufen",
                    color: "red",
                });
            }
        }, 500);

    } else if (errMessage.length === 1) {
        $q.notify({
            type: "negative",
            message: errMessage[0],
            color: "red",
        });
    } else {
        $q.notify({
            type: "negative",
            message: "Mehrere Angaben Fehlen: " + errMessage.length + " fehlende Angaben",
            color: "red",
        });
    }
}

async function validate1() {
    fileRef.value.validate();
    textRef.value.validate();
    titleRef.value.validate();
    checkRef.value.validate();
    addressFormRef.value.myvalidate();
    let errMessage = [] as string[];
    const propertiesUser = Object.getOwnPropertyNames(usermodel.value);
    const propertiesProject = Object.getOwnPropertyNames(projectmodel.value);
    const mailcheck = ref(true);

    propertiesUser.forEach(property => {
        if (usermodel.value[property] === null || usermodel.value[property] === "") {
            switch (property) {
                case "name":
                    errMessage.push("Der Vorname fehlt!");
                    break;
                case "surname":
                    errMessage.push("Der Nachname fehlt!");
                    break;
                case "email":
                    errMessage.push("Die E-Mail fehlt!");
                    mailcheck.value = false;
                    break;
            }
        }
    });
    propertiesProject.forEach(property => {
        if (projectmodel.value[property] === null || projectmodel.value[property] === "") {
            switch (property) {
                case "title":
                    errMessage.push("Titel zum Projekt fehlt!");
                    break;
                case "text":
                    errMessage.push("Projekt beschreibung fehlt!");
                    break;
            }
        }
    });
    if (!teilnahmebedingungenbestaetigung.value) {
        errMessage.push("Teilnahmebedingungen wurden nicht bestätigt!");
    }
    if (fileRef.value.hasError) {
        errMessage.push("Es fehlen Bilder!");
    }
    console.log(mailcheck.value);
    console.log(isValidEmail(usermodel.value.email));
    if (mailcheck.value == true && !isValidEmail(usermodel.value.email)) {
        errMessage.push("Ungültige Mailadresse");
    }
    console.log(errMessage);
    return errMessage;
}

function datecheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    return (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    );
}

function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || false;
}

function checkFileType(files: object) {
    return files.filter((file: object) => file.type === "image/png" || file.type === "image/jpeg");
}

function onRejected(rejectedEntries: object) {
    $q.notify({
        type: "negative",
        message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
    });
}

async function load() {
    await competitionstore.getCompetitiondeclarations();
}

load();
</script>

<template>
    <loading
        v-model="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.021)"
        :can-cancel="true"
        :is-full-page="fullPage"
    ></loading>
    <div v-if="datecheck()">
        <q-card flat>
            <q-card-section align="center" v-html="competitionDetails.title" />
        </q-card>
        <q-card flat>
            <q-card-section align="left" v-html="competitionDetails.text" />
        </q-card>
        <form @submit.prevent.stop="sendcompetition" class="row q-pa-md">
            <div class="col-4 textarea" style="max-width: 30%">
                <q-input
                    v-model="projectmodel.title"
                    ref="titleRef"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    label="Titel zum Projekt *"
                />
                <q-input
                    v-model="projectmodel.text"
                    ref="textRef"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    label="Beschreibung zum Projekt *"
                    autogrow
                />
            </div>
            <div class="col-1"></div>
            <div class="place row col-7 q-gutter-md">
                <Formular ref="addressFormRef" @change:declarations="changeUserModel" />
                <q-file
                    class="picloader"
                    ref="fileRef"
                    v-model="filesPng"
                    rounded
                    outlined
                    append
                    use-chips
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    label="Filtered (png,jpeg only) *"
                    multiple
                    :filter="checkFileType"
                    @rejected="onRejected"
                    counter
                >
                    <template #prepend>
                        <q-icon name="attach_file" />
                    </template>
                    <template #file="{ file }">
                        <q-chip class="fileele full-width q-my-xs" square>
                            <q-avatar size="50px" icon="description" text-color="blue" color="white"></q-avatar>
                            {{ file.name }}
                            <q-space />
                            <q-btn class="fileele q-pa-sm" flat icon="delete" @click="remove(file)" />
                        </q-chip>
                    </template>
                </q-file>
                <q-field
                    :value="teilnahmebedingungenbestaetigung"
                    ref="checkRef"
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    dense
                    borderless
                >
                    <q-checkbox
                        right-label
                        v-model="teilnahmebedingungenbestaetigung"
                        label="Teilnahmebedingungen annehmen"
                        class="col-4"
                    />
                </q-field>
                <q-space />
                <q-btn label="Senden" :loading="isLoading" color="green" @click="sendcompetition" class="col-3" />
            </div>
        </form>
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
                        <q-btn flat label="OK" color="primary" v-close-popup />
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

.fileele {
    min-height: 50px;
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
</style>
