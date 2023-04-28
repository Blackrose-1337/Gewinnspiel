<script setup lang="ts">
//--------------------- import ----------------------------------
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";
import { useProjectStore } from "@/stores/projects";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import {computed, onBeforeMount, ref} from "vue";
import { useUserStore } from "@/stores/users";
import { useAuthStore } from "@/stores/auth";
import { useCompetitionStore } from "@/stores/competition";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import Loading from "vue-loading-overlay";
import { storeToRefs } from "pinia";

//--------------------- Storeload --------------------------------
const authStore = useAuthStore();
const userStore = useUserStore();
const projectStore = useProjectStore();
const competitionStore = useCompetitionStore();
const evaluationStore = useEvaluationStore();

//--------------------- variable's -------------------------------
const $q = useQuasar();
const router = useRouter();
var bild = new Image();
let isLoading = ref(false);
const fullPage = ref(true);
const projectRef = ref(null); //ref to child component
const formularRef = ref(null); //ref to child component

//--------------------- computed ---------------------------------
const project = computed(() => projectStore.project);
const selectedUser = computed(() => userStore.user);
const competitionDetails = computed(() => competitionStore.competitionDetails);
const img = computed(() => evaluationStore.img);

//--------------------- storeToRefs ------------------------------
const { pics } = storeToRefs(projectStore);
const { tempImage } = storeToRefs(projectStore);
const { tempProject } = storeToRefs(projectStore);

//--------------------- function's -------------------------------
//----------------- function's for check -------------------------
//check if user is logged in
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
//check if competition is open
function dateCheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    return (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    );
}
//----------------- function's from child ------------------------
//call child function
async function callChildFunction() {
    if (projectRef.value.myvalidate() && formularRef.value.myvalidate()) {
        isLoading.value = true;
        const bool: number = await projectStore.postProject();
        const ans = await projectStore.postPicUpload();
        await evaluationStore.getImages(project.value.id);
        const answer: number = await userStore.saveUserChange();
        await projectStore.clearPics();
        project.value.pics = img;
        tempProject.value.pics = img;
        tempImage.value.splice(0, tempImage.value.length);
        await loadImage();
        switch (ans) {
            case 1:
                $q.notify({
                    type: "positive",
                    message: `Das Bild wurde erfolgreich hochgeladen`,
                });
                break;
            case 0:
                $q.notify({
                    type: "negative",
                    message: `Das Bild wurde nicht hochgeladen`,
                });
                break;
            case 2:
                break;
        }
        if (bool === 1 || answer === 1) {
            $q.notify({
                type: "positive",
                message: "Änderung wurden gespeichert!",
                color: "green",
            });
        } else if (bool === 0 || answer === 0) {
            $q.notify({
                type: "negative",
                message: "Der Speichervorgang ist gescheitert",
                color: "red",
            });
        }
    } else {
        $q.notify({
            type: "negative",
            message: "Bitte füllen Sie alle Pflichtfelder aus",
            color: "red",
        });
    }
}
//----------------- function's for load --------------------------
//load images
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

//----------------- function's for Mount -------------------------
onBeforeMount(async () => {
    await check();
    await userStore.getUser();
    await competitionStore.getCompetitionDeclarations();
});
// onMounted(async () => {
// 	await userStore.getUser();
// });
</script>
<template>
    <loading
        v-model="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.223)"
        :can-cancel="true"
        :is-full-page="fullPage"
    ></loading>
    <div v-if="dateCheck()" class="row">
        <div class="q-ma-md col user-E">
            <Project :user="selectedUser" ref="projectRef" :view="'User'" />
        </div>

        <div class="q-ma-md col user-E">
            <Formular :user="selectedUser" ref="formularRef" :view="'User'" />
            <div class="row">
                <q-space />
                <q-btn
                    class="genBtn"
                    color="blue"
                    :loading="isLoading"
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
<style scoped>
.user-E {
    min-width: 500px;
}
</style>
