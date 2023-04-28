<script setup lang="ts">
//--------------------- Imports ----------------------------------
import { useQuasar } from "quasar";
import type { Project, ProjectBild, User } from "@/stores/interfaces";
import { useProjectStore } from "@/stores/projects";
import { computed, onMounted, ref, toRefs, watch } from "vue";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import Loading from "vue-loading-overlay";
import { storeToRefs } from "pinia";
import { isArray } from "lodash";

//--------------------- Props ------------------------------------
const props = defineProps<{
    user?: User;
    selectedproject?: Project;
    view?: string;
}>();

//--------------------- Storeload --------------------------------
const projectStore = useProjectStore();
const evaluationstore = useEvaluationStore();
const $q = useQuasar();

//--------------------- variable's -------------------------------
const proTitleRef = ref(null);
const proTextRef = ref(null);
const fullPage = ref(true);
const dialog = ref(false);
let isLoading = ref(false);
const maxfilecount = ref();
let previewImage = ref();
let bild = new Image();

//--------------------- computed ---------------------------------
const project = computed(() => projectStore.project);
let newimage = computed(() => projectStore.newImage);
const img = computed(() => evaluationstore.img);

//--------------------- storeToRefs ------------------------------
const { pics } = storeToRefs(projectStore);
const { tempImage } = storeToRefs(projectStore);
const { tempProject } = storeToRefs(projectStore);

//--------------------- toRefs to props---------------------------
const { user } = toRefs(props) as User;
const { selectedproject } = toRefs(props) as Project;
const { view } = toRefs(props);

//--------------------- function's -------------------------------
//--------------- function's for save ----------------------------
// save: Speichervorgang Initialisiert den Post zum Backend mit allen vorgenommen Änderungen an dem Project
async function save() {
    const bool: boolean = await projectStore.postProject();
    if (bool) {
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
        isLoading.value = false;
    }
}
// Bilder werden per Post an das Backend gesendet zum speichern und die Bilder werden frisch abgefragt
async function upload() {
	isLoading.value = true;
    if (projectStore.newImage.length < 1) {
        $q.notify({
            type: "negative",
            message: `Es sind keine Bilder zum hochgeladen bereitgestellt`,
        });
    } else {
        const ans = await projectStore.postPicUpload();
        await evaluationstore.getImages(project.value.id);
        await projectStore.clearPics();
        project.value.pics = img;
        tempProject.value.pics = img;
        tempImage.value.splice(0, tempImage.value.length);
        if (ans === 1) {
            $q.notify({
                type: "positive",
                message: `Das Bild wurde erfolgreich hochgeladen`,
            });
            projectStore.newImage.splice(0);
            await loadImage();
        } else {
            $q.notify({
                type: "negative",
                message: `Das Bild wurde nicht hochgeladen`,
            });
        }
    }
	isLoading.value = false;
}
// approval:  Freigabe des Projektes per Post Initialisieren
async function approval() {
    const ans = await projectStore.approvalPost();
    if (ans) {
        await projectStore.getProjects();
        $q.notify({
            type: "positive",
            message: `Das Projekt wurde freigegeben`,
        });
        await projectStore.getProjects();
    } else {
        $q.notify({
            type: "negative",
            message: `Das Projekt wurde nicht freigegeben`,
        });
    }
    isLoading.value = false;
}

//--------------- function's for remove -------------------------
// remove:  Löschen des Projektes per Post Initialisieren
async function remove() {
    const answer = await projectStore.projectRemove(project.value.id);
    if (answer["answer"] == true) {
        $q.notify({
            type: "positive",
            message: "User & Projekt wurde gelöscht",
            color: "green",
        });
        await projectStore.getProjects();
    } else {
        $q.notify({
            type: answer["type"],
            message: answer["message"],
        });
    }
}
// removepic:  Löschen des Bildes per Post Initialisieren
async function removepic(file: string) {
    const ans = await projectStore.deletePic(file.toString());
    await evaluationstore.getImages(project.value.id);
    await projectStore.clearPics();
    project.value.pics = img;
    tempProject.value.pics = img;
    if (ans === 1) {
        $q.notify({
            type: "positive",
            message: `Das Bild wurde gelöscht`,
        });
        await loadImage();
    } else {
        $q.notify({
            type: ans["type"],
            message: ans["message"],
        });
    }
}

//--------------- function's for load ---------------------------
// Bilder im Store bereitstellen
async function loadIntoStore() {
    if (newimage.value.length > 0) {
        newimage.value.splice(0);
    }
    //abfrage ob Bilder hochgeladen wurden falls ja werden diese in Base64 konvertiert
    if (tempImage.value) {
        let promises = [];
        for (let index = 0; index < tempImage.value.length; index++) {
            let file = tempImage.value[index];
            let reader = new FileReader();
            let promise = new Promise<void>(resolve => {
                reader.onloadend = function () {
                    const bild: ProjectBild = {
                        id: 0,
                        projectId: project.value.id,
                        bildbase: reader.result as string,
                    };
                    newimage.value.push(bild);
                    resolve();
                };
                reader.readAsDataURL(file);
            });
            promises.push(promise);
        }
        await Promise.all(promises);
    }
}
// Bilder vom Store werden bereitgestellt zur Darstellung
async function loadImage() {
    isLoading.value = true;
    pics.value = [];
    if (isArray(project.value.pics)) {
        project.value.pics.forEach((e: { img: string }) => {
            bild.src = e.img;
            pics.value.push(bild.src);
        });
        maxfilecount.value = 10 - pics.value.length;
    }
    setTimeout(() => {
        isLoading.value = false;
    }, 500);
}
// Abruf vom Projekt mittels userId und initialisiert loadImage()
async function load() {
    isLoading.value = true;
    if (user.value !== null) {
        await projectStore.clearPics();
        await projectStore.getProject(user.value.id);
        await loadImage();
    }
}
// Vorhandes Project wird dem selectedproject zugewissen
async function loadProject() {
    pics.value = [];
    isLoading.value = true;
    if (selectedproject.value) {
        await projectStore.setProject(selectedproject.value);
    }
    await evaluationstore.getImages(project.value.id);
    await projectStore.clearPics();
    project.value.pics = img;
    await loadImage();
}

//--------------- function's for validation ---------------------
// Validierung ob die Files als PNG oder JPEG Format hochgeladen wurden
function checkFileType(files: object) {
    return files.filter((file: object) => file.type === "image/png" || file.type === "image/jpeg");
}
// Reaktion wenn die Validierung fehlschlaegt
function onRejected(rejectedEntries: object) {
    $q.notify({
        type: "negative",
        message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
    });
}
// Initialisierung der Validierung von Titel und Text
function myvalidate() {
    return !!(proTitleRef.value.validate() && proTextRef.value.validate());
}
// "Exportiert" die Funktion myvalidate() um sie in anderen Komponenten verwenden zu können
defineExpose({ myvalidate, loadProject });

//--------------- function's for image handling --------------------------
// Bild vergrössern
function showImage(image: string) {
    previewImage.value = image;
}
// Bild auf default grösse setzen
function hideImage() {
    previewImage.value = null;
}

//--------------- function's for watch/onMounted --------------------------
// Wird initialisiert wenn sich user prop ändert
watch(user, changeuser => {
    load();
});
// Bevor die Seite geladen wird load() initialisiert, wenn prop View nicht Project oder evaluation entspricht
onMounted(() => {
    if (view?.value !== "Project" && view?.value !== "evaluation") {
        if (typeof user.value.id !== "undefined") {
            load();
        }
    }
});

// Wird initialisiert wenn sich selectedproject prop ändert
watch(selectedproject, changeselectedproject => {
    loadProject();
});
</script>

<template>
    <loading
        v-model="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.223)"
        :can-cancel="true"
        :is-full-page="fullPage"
    ></loading>
    <div v-if="view === 'Project' || view === 'User'">
        <div class="q-ma-sm">
            <h4 class="q-mt-sm">Projekttitle</h4>
            <q-input ref="proTitleRef" standout="bg-secondary" v-model="project.title" outlined class="q-mt-sm" />
            <h4 class="q-mt-sm">Projekttext</h4>
            <q-input
                ref="proTextRef"
                standout="bg-secondary"
                v-model="project.text"
                outlined
                class="q-mt-sm"
                autogrow
            />
        </div>
        <div class="q-pa-sm">
            <q-file
                for="qfileelements"
                class="picloader"
                v-model="tempImage"
                standout="bg-secondary"
                label-color="accent"
                outlined
                append
                use-chips
                multiple
                label="Bilder-Upload (max. 5MB pro Bild): Nur JPEG/PNG. *"
                counter
                :max-files="maxfilecount"
                max-file-size="5242880"
                :filter="checkFileType"
                @rejected="onRejected"
                @update:model-value="loadIntoStore"
            >
            </q-file>
        </div>
        <div class="row justify-between">
            <div class="column content-center image-container q-pa-sm">
                <div v-for="pic in pics" :key="pic" class="row">
                    <img
                        alt="Bilddarstellung eines Verlinkten Bildes des Projektes"
                        :src="pic"
                        @click="showImage(pic)"
                    />
                    <q-btn class="fileele" flat icon="delete" @click="removepic(pic)" />
                </div>
                <div class="image-preview" v-if="previewImage" @click="hideImage">
                    <img
                        alt="Bilddarstellung eines Verlinkten Bildes des Projektes"
                        :src="previewImage"
                        @click="hideImage"
                    />
                </div>
            </div>
            <!--     Buttons     -->
            <div v-if="view === 'Project'">
                <div class="row">
                    <q-space />
                    <q-btn
                        class="genBtn"
                        :loading="isLoading"
                        color="accent"
                        label="Bilder Speichern"
                        icon="upload"
                        @click="upload"
                    />
                </div>
                <div class="row">
                    <q-space />
                    <q-btn
                        :loading="isLoading"
                        label="Änderungen Speichern"
                        color="accent"
                        @click="save"
                        class="genBtn"
                    />
                </div>
                <div class="row">
                    <q-space />
                    <q-btn
                        label="Projekt Freigeben"
                        :loading="isLoading"
                        color="green-5"
                        @click="approval"
                        class="genBtn"
                    >
                        <q-tooltip class="bg-accent">Das Projekt wird als kontrolliert markiert</q-tooltip>
                    </q-btn>
                </div>
                <div class="row">
                    <q-space />
                    <q-btn
                        label="User & Projekt Löschen"
                        :loading="isLoading"
                        color="red-5"
                        @click="dialog = true"
                        class="genBtn"
                    />
                </div>
                <div>
                    <q-dialog v-model="dialog" persistent transition-show="scale" transition-hide="scale">
                        <q-card class="bg-grey-3 text-black" style="width: 300px">
                            <q-card-section class="bg-red-5">
                                <div class="text-h6">Löschen?!?</div>
                            </q-card-section>

                            <q-card-section class="q-pt-none bg-secondary">
                                Möchten Sie wirklich den User & das Projekt vollständig Löschen?
                            </q-card-section>

                            <q-card-actions align="right" class="bg-secondary text-teal">
                                <q-btn
                                    flat
                                    color="black"
                                    class="bg-red-5"
                                    label="Löschen"
                                    @click="remove"
                                    v-close-popup
                                />
                                <q-btn flat color="black" class="bg-grey-5" label="Abbrechen" v-close-popup />
                            </q-card-actions>
                        </q-card>
                    </q-dialog>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="texts q-pa-lg bg-secondary">
            <h3>{{ project.title }}</h3>
            <p>{{ project.text }}</p>
        </div>
        <div class="row content-center image-container">
            <img
                class="imgwitdh"
                alt="Bilddarstellung eines Verlinkten Bildes des Projektes"
                v-for="pic in pics"
                :key="pic"
                :src="pic"
                @click="showImage(pic)"
            />
            <div class="image-preview" v-if="previewImage" @click="hideImage">
                <img
                    alt="Bilddarstellung eines Verlinkten Bildes des Projektes"
                    :src="previewImage"
                    @click="hideImage"
                />
                <br />
            </div>
        </div>
        <div class="q-pb-xl"></div>
    </div>
</template>

<style scoped>
.image-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.image-container img {
    width: auto;
    max-height: 25vh;
    max-width: 30vw;
    padding: 5px;
    cursor: pointer;
    filter: brightness(100%);
    transition: filter 0.3s;
}
.image-container img:hover {
    filter: brightness(80%);
}
.image-preview img {
    object-fit: contain;
    cursor: pointer;
    transform: scale(4);
}
.image-preview img:hover {
    filter: brightness(100%);
}
.image-preview {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.823);
    z-index: 9999; /* sorgt dafür, dass das Vorschaubild immer über anderen Inhalten erscheint */
}
.texts {
    border-radius: 5px;
    margin: 10px;
}
.fileele {
    min-height: 50px;
}
@media (max-width: 1200px) {
    .imgwitdh {
        max-height: 200px !important;
    }
}
</style>
