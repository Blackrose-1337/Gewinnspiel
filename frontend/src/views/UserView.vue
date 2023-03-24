<script setup lang="ts">
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";
import { useProjectStore } from "@/stores/projects";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import { computed, onBeforeMount, ref } from "vue";
import { useUserStore } from "@/stores/users";
import { useAuthStore } from "@/stores/auth";
import { useCompetitionStore } from "@/stores/competition";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import Loading from "vue-loading-overlay";
import { storeToRefs } from "pinia";

//--------------- Storeload ------------------------------

const authStore = useAuthStore();
const userStore = useUserStore();
const projectStore = useProjectStore();
const competitionstore = useCompetitionStore();
const evaluationstore = useEvaluationStore();

//--------------- variables ------------------------------
const $q = useQuasar();
const router = useRouter();
var bild = new Image();
let isLoading = ref(false);
const fullPage = ref(true);

//--------------- computed ------------------------------
const project = computed(() => projectStore.project);
const selectedUser = computed(() => userStore.user);
const competitionDetails = computed(() => competitionstore.competitionDetails);
const img = computed(() => evaluationstore.img);

//---------------storeToRefs------------------------------
const { pics } = storeToRefs(projectStore);
const { tempImage } = storeToRefs(projectStore);

competitionstore.getCompetitionDeclarations();

//--------------- functions ------------------------------
async function check() {
    const answer: boolean = await authStore.check();
    if (!answer) {
        await router.push("/login");
    } else if (authStore.role == "jury") {
        await router.push("/evaluation");
    } else if (authStore.role == "admin") {
        await router.push("/");
    }
}
function dateCheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    return (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    );
}
async function callChildFunction() {
    isLoading.value = true;
    const bool: boolean = await projectStore.postProject();
    const ans = await projectStore.postPicUpload();
    await evaluationstore.getImages(project.value.id);
    const answer = await userStore.saveUserChange();
    await projectStore.clearPics();
    project.value.pics = img;
    tempImage.value.splice(0, tempImage.value.length);
    await loadImage();
    if (ans === 1) {
        $q.notify({
            type: "positive",
            message: `Das Bild wurde erfolgreich hochgeladen`,
        });
    } else if (ans === 0) {
        $q.notify({
            type: "negative",
            message: `Das Bild wurde nicht hochgeladen`,
        });
    } else {
        $q.notify({
            type: "",
            message: `Keine Bilder im Upload`,
        });
    }
    if (bool && answer == true) {
        $q.notify({
            type: "positive",
            message: "Änderung wurden gespeichert!",
            color: "green",
        });
    } else {
        $q.notify({
            type: "negative",
            message: "Der Speichervorgang ist gescheitert",
            color: "red",
        });
    }
}
async function loadImage() {
    pics.value = [];
    if (project.value.pics !== null && project.value.pics !== "undefined") {
        project.value.pics.forEach((e: { img: string }) => {
            bild.src = e.img;
            pics.value.push(bild.src);
        });
    }
    setTimeout(() => {
        isLoading.value = false;
    }, 500);
}

onBeforeMount(() => {
    check();
    userStore.getUser();
});
</script>
<template>
    <loading
        v-model="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.223)"
        :can-cancel="true"
        :is-full-page="fullPage"
    ></loading>
    <div v-if="dateCheck()" class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Project :user="selectedUser" :view="'User'" />
        </div>

        <div class="q-gutter-lg col-5">
            <Formular :user="selectedUser" :view="'User'" />
            <div class="row">
                <q-space />
                <q-btn
                    class="genBtn"
                    color="blue"
                    label="Änderungen Speichern"
                    icon="upload"
                    @click="callChildFunction"
                />
            </div>
        </div>
    </div>
    <div v-else>
        <q-card flat align="center">
            <q-card-section v-html="competitionDetails.wettbewerbCloseText" />
        </q-card>
    </div>
</template>
<style scoped></style>
