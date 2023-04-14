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
    strasse: "",
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

async function sendCompetition() {
    const errMessage = await fillValidate();
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
            if (ans === 1) {
                isLoading.value = false;
                dialog.value = true;
                $q.notify({
                    type: "positiv",
                    message: "Ihr Gewinnspielsteilnahme wurde versendet",
                    color: "green",
                });
            } else if (ans === 2) {
                isLoading.value = false;
                $q.notify({
                    type: "negative",
                    message: "Sie haben bereits am Gewinnspiel teilgenommen",
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

async function fillValidate() {
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
                case "land":
                    errMessage.push("Das Land fehlt!");
                    break;
                case "plz":
                    errMessage.push("Die Postleitzahl fehlt!");
                    break;
                case "ortschaft":
                    errMessage.push("Die Ortschaft fehlt!");
                    break;
                case "strasse":
                    errMessage.push("Die Strasse fehlt!");
                    break;
                case "strNr":
                    errMessage.push("Die Strassennummer fehlt!");
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
    } else if (filesPng.value.length === 0) {
        errMessage.push("Es fehlen Bilder!");
        console.log(fileRef.value);
        fileRef.value.validate();
    }
    if (mailcheck.value == true && !isValidEmail(usermodel.value.email)) {
        errMessage.push("Ungültige Mailadresse");
    }
    return errMessage;
}

function dateCheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    return (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    );
}

function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9äöüÄÖÜ@._%+-]{6,254}$)[a-zA-Z0-9äöüÄÖÜ._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || false;
}
function validatefilesPng() {
    return filesPng.value.length > 0;
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
    await competitionstore.getCompetitionDeclarations();
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
    <div v-if="dateCheck()">
        <q-card class="bg-primary" flat>
            <q-card-section align="center" v-html="competitionDetails.title" />
        </q-card>
        <q-card class="bg-primary" flat>
            <q-card-section align="left" v-html="competitionDetails.text" />
        </q-card>
        <form @submit.prevent.stop="sendCompetition" class="row q-pa-md">
            <div id="comp" class="col-4 comp-proj q-ma-sm">
                <div class="textarea full-width">
                    <q-input
                        class="q-ma-sm"
                        v-model="projectmodel.title"
                        ref="titleRef"
                        standout="bg-secondary"
                        label-color="accent"
                        label="Titel zum Projekt *"
                        outlined
                        lazy-rules
                        :rules="[val => !!val || 'Pflichtfeld *']"
                    />
                    <q-input
                        class="q-ma-sm"
                        v-model="projectmodel.text"
                        ref="textRef"
                        standout="bg-secondary"
                        label-color="accent"
                        label="Beschreibung zum Projekt *"
                        outlined
                        autogrow
                        lazy-rules
                        :rules="[val => !!val || 'Pflichtfeld *']"
                    />
                </div>
            </div>
            <div id="comp" class="col-6">
                <div class="place row q-ma-md">
                    <Formular id="comp" ref="addressFormRef" @change:declarations="changeUserModel" />
                    <q-file
                        for="qfileelements"
                        class="picloader col-11 q-mt-md"
                        ref="fileRef"
                        v-model="filesPng"
                        standout="bg-secondary"
                        label-color="accent"
                        outlined
                        append
                        use-chips
                        multiple
                        :rules="[val => !!val || 'Pflichtfeld *', validatefilesPng]"
                        label="Bilder-upload (jpeg + png only) *"
                        counter
                        max-files="10"
                        max-file-size="5242880"
                        :filter="checkFileType"
                        @rejected="onRejected"
                    >
                        <q-tooltip class="bg-accent">Zum Hochladen von Bildern einfach in das Feld klicken.</q-tooltip>
                    </q-file>
                    <q-field
                        v-model="teilnahmebedingungenbestaetigung"
                        color="accent"
                        ref="checkRef"
                        :rules="[val => !!val || 'Pflichtfeld *']"
                        dense
                        borderless
                    >
                        <q-checkbox
                            standout="bg-secondary"
                            color="accent"
                            right-label
                            v-model="teilnahmebedingungenbestaetigung"
                            label="Teilnahmebedingungen annehmen"
                            class="col-4"
                        />
                    </q-field>
                    <q-space />
                    <q-btn
                        label="Senden"
                        :loading="isLoading"
                        @click="sendCompetition"
                        class="genBtn bg-accent col-3"
                    />
                </div>
            </div>
        </form>
        <div class="q-pa-md">
            <h5>Teilnahmebedingungen</h5>
            <q-card class="bg-primary" flat>
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
                        <q-btn flat label="OK" class="bg-accent" v-close-popup />
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
    border: 1px solid black;
    border-radius: 5px;
}
.comp-proj {
    min-width: 400px;
}
@media (max-width: 1100px) {
    #comp {
        min-width: 400px;
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
        padding-right: -24px;
    }
}
/*h3 {*/
/*    text-shadow: 1px 1px 1px black, 1px -1px 1px black, -1px 1px 1px black, -1px -1px 1px black;*/
/*    color: #4967de46;*/
/*    font-weight: bold;*/
/*    text-align: center;*/
/*}*/
</style>
