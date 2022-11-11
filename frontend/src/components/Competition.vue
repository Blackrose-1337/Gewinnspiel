<script setup lang="ts">
import { ref } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import Formular from "@/components/Formular.vue";
import { useUserStore } from "@/stores/users";
import { useCompetitionStore } from "@/stores/competition";
import type { User, Project, Competiion } from "@/stores/interfaces";

const $q = useQuasar();

const userstore = useUserStore();
const competitionstore = useCompetitionStore();

const { competition, competitionDetails } = storeToRefs(competitionstore);
const { user } = storeToRefs(userstore);

const usermodel = ref() as User;
const projectmodel: Project = ref({
    id: 0,
    userId: 0,
    title: "",
    text: "",
}) as Project;

function changeUserModel(u: User) {
    usermodel.value = u;
}

function sendcompetition() {
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
    } else if (usermodel.value.email == "" || usermodel.value.email == null) {
        $q.notify({
            type: "negative",
            message: "Die E-Mail fehlt!",
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
        competition.value.project = projectmodel.value;
        competition.value.user = usermodel.value;
        competitionstore.postCompetition(competition.value);
    }
}
function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}
function test2() {
    userstore.getUsers();
}

function checkFileSize(files: any) {
    return files.filter((file: any) => file.size < 2048);
}

function checkFileType(files: any) {
    return files.filter((file: any) => file.type === "image/png");
}

function onRejected(rejectedEntries: any) {
    // Notify plugin needs to be installed
    // https://quasar.dev/quasar-plugins/notify#Installation
    $q.notify({
        type: "negative",
        message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
    });
}

const teilnahmebedingungenbestätigung = ref(false);

async function load() {
    await competitionstore.getCompetitiondeclarations();
    console.log(competitionDetails);
}
load();
</script>

<template>
    <h3>{{ competitionDetails.title }}</h3>
    <div class="q-pa-md">
        <p>
            {{ competitionDetails.text }}
        </p>
    </div>
    <div class="row q-pa-md">
        <div class="col-4 textarea" style="max-width: 30%">
            <q-input v-model="projectmodel.title" label="Titel zum Projekt" />
            <q-input v-model="projectmodel.text" label="Beschreibung zum Projekt" autogrow />
        </div>
        <div class="col-1"></div>

        <div class="muh row col-7 q-gutter-md">
            <Formular @change:declarations="changeUserModel" />

            <q-uploader
                class="col-11"
                max-files="3"
                url="http://localhost:4444/upload"
                label="Bilderhochladen"
                accept=".jpg, image/*"
                multiple
                :filter="checkFileType"
                @rejected="onRejected"
            />
            <q-checkbox
                left-label
                v-model="teilnahmebedingungenbestätigung"
                label="Teilnahmebedingungen"
                class="col-4"
            />
            <q-space />
            <q-btn label="Senden" color="green" @click="sendcompetition" class="col-3" />
            <q-btn label="Get" color="red" @click="test2" class="col-3" />
        </div>
    </div>
    <div class="textarea">
        <h5>Teilnahmebedingungen</h5>
        <p>{{ competitionDetails.teilnehmerbedingung }}</p>
    </div>
</template>

<style scoped>
.muh {
    /* height: 20vh; */
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
    color: #00baff;
    font-weight: bold;
    text-align: center;
}
</style>
