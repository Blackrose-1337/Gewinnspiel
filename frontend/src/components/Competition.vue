<script setup lang="ts">
import { ref } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import Formular from "@/components/Formular.vue";
import { useUserStore } from "@/stores/users";
import { useCompetitionStore } from "@/stores/competition";
import type { User } from "@/stores/interfaces";

const $q = useQuasar();

const userstore = useUserStore();
const competitionstore = useCompetitionStore();

const { competition } = storeToRefs(competitionstore);
const { teststroe } = storeToRefs(userstore);

const usermodel = ref() as User;

function changeUserModel(u: User) {
    usermodel.value = u;
    console.log("change: " + usermodel.value);
}

function test() {
    console.log(usermodel.value);
    userstore.posttest(usermodel.value);
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

const project = ref({
    id: 0,
    title: "",
    text: "",
});
const teilnahmebedingungenbestätigung = ref(false);
function load() {
    competitionstore.getCompetition();
}
load();
</script>

<template>
    <h3>{{ competition.title }}</h3>
    <div class="q-pa-md">
        <p>
            {{ competition.text }}
        </p>
    </div>
    <h4>{{ usermodel }}</h4>
    <div class="row q-pa-md">
        <div class="col-4 textarea" style="max-width: 30%">
            <q-input v-model="project.title" label="Titel zum Projekt" />
            <q-input v-model="project.text" label="Beschreibung zum Projekt" autogrow />
        </div>
        <div class="col-1"></div>

        <div class="muh row col-7 q-gutter-md">
            <Formular @change:declarations="changeUserModel" />

            <q-uploader
                class="col-11"
                max-files="3"
                url="http://localhost:4444/upload"
                label="Filtered (png only)"
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
            <q-btn label="Senden" color="green" @click="test" class="col-3" />
            <q-btn label="Get" color="red" @click="test2" class="col-3" />
        </div>
    </div>
    <div class="textarea">
        <h5>Teilnahmebedingungen</h5>
        <p>{{ competition.teilnehmerbedingung }}</p>
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
