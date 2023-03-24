<script setup lang="ts">
import { useQuasar } from "quasar";
import type { Project, ProjectBild, User } from "@/stores/interfaces";
import { useProjectStore } from "@/stores/projects";
import { computed, onMounted, ref, toRefs, watch } from "vue";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import Loading from "vue-loading-overlay";
import { storeToRefs } from "pinia";

//--------------- Props ------------------------------
const props = defineProps<{
    user?: User;
    selectedproject?: Project;
    view?: string;
}>();

//--------------- Storeload ------------------------------
const projectStore = useProjectStore();
const evaluationstore = useEvaluationStore();
const $q = useQuasar();

//--------------- variables ------------------------------
let isLoading = ref(false);
const fullPage = ref(true);
let previewImage = ref();
var bild = new Image();

//--------------- computed ------------------------------
const project = computed(() => projectStore.project);
let newimage = computed(() => projectStore.newImage);
const img = computed(() => evaluationstore.img);

//--------------- storeToRefs ------------------------------
const { pics } = storeToRefs(projectStore);
const { tempImage } = storeToRefs(projectStore);

//--------------- toRefs to props------------------------------
const { user } = toRefs(props) as User;
const { selectedproject } = toRefs(props) as Project;
const { view } = toRefs(props);

//--------------- funcions ------------------------------
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
    }
}
// remove:  Löschen des Projektes per Post Initialisieren
async function remove() {
    const bool: boolean = await projectStore.projectRemove(project.value.id);
    if (bool) {
        $q.notify({
            type: "positive",
            message: "Bilder und Projekt wurden gelöscht",
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
// removepic:  Löschen des Bildes per Post Initialisieren
async function removepic(file: string) {
    const ans = await projectStore.deletePic(file.toString());
    await evaluationstore.getImages(project.value.id);
    await projectStore.clearPics();
    project.value.pics = img;
    tempImage.value.splice(0, tempImage.value.length);
    if (ans === 1) {
        $q.notify({
            type: "positive",
            message: `Das Bild wurde gelöscht`,
        });
        await loadImage();
    } else {
        $q.notify({
            type: "negative",
            message: `Das Bild wurde nicht gelöscht`,
        });
    }
}

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
// Bilder werden per Post an das Backend gesendet zum speichern und die Bilder werden frisch abgefragt
async function upload() {
    const ans = await projectStore.postPicUpload();
    await evaluationstore.getImages(project.value.id);
    await projectStore.clearPics();
    project.value.pics = img;
    tempImage.value.splice(0, tempImage.value.length);
    if (ans === 1) {
        $q.notify({
            type: "positive",
            message: `Das Bild wurde erfolgreich hochgeladen`,
        });
        loadImage();
    } else {
        $q.notify({
            type: "negative",
            message: `Das Bild wurde nicht hochgeladen`,
        });
    }
}
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

// Bilder vom Store werden bereitgestellt zur Darstellung
async function loadImage() {
    isLoading.value = true;
    pics.value = [];
    if (project.value.pics !== null || project.value.pics !== "undefined") {
        project.value.pics.forEach((e: { img: string }) => {
            bild.src = e.img;
            pics.value.push(bild.src);
        });
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
    await projectStore.setProject(selectedproject.value);
    await evaluationstore.getImages(selectedproject.value.id);
    await projectStore.clearPics();
    project.value.pics = img;
    await loadImage();
}
defineExpose({ loadProject });
// Bild vergrössern
function showImage(image: string) {
    previewImage.value = image;
}
// Bild auf default grösse setzen
function hideImage() {
    previewImage.value = null;
}
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
    console.log(selectedproject.value);
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
        <div>
            <h4 class="q-ma-md">Projekttitle</h4>
            <q-input v-model="project.title" outlined class="q-ma-md" />
            <h4 class="q-ma-md">Projekttext</h4>
            <q-input v-model="project.text" outlined class="q-ma-md" autogrow />
        </div>
        <div class="q-pa-sm">
            <q-file
                for="qfileelements"
                class="picloader"
                v-model="tempImage"
                rounded
                outlined
                append
                use-chips
                multiple
                label="Filtered (png,jpeg only) *"
                counter
                :filter="checkFileType"
                @rejected="onRejected"
                @update:model-value="loadIntoStore"
            >
                <!--                <template #file="{ file }">
                    <q-chip class="fileele full-width q-my-xs" square>
                        <q-avatar size="50px" icon="description" text-color="blue" color="white"> </q-avatar>
                        {{ file.name }}
                        <q-space />
                        <q-btn class="fileele q-pa-sm" flat icon="delete" @click.stop @click="removeImage(file)" />
                    </q-chip>
                </template>-->
            </q-file>
        </div>
        <div class="row justify-between">
            <div class="column content-center image-container q-pa-sm">
                <div v-for="pic in pics" class="row">
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
                    <q-btn class="genBtn" color="blue" label="Bilder Speichern" icon="upload" @click="upload" />
                </div>
                <div class="row">
                    <q-space />
                    <q-btn label="Änderungen Speichern" color="blue" @click="save" class="genBtn" />
                </div>
                <div class="row">
                    <q-space />
                    <q-btn label="Projekt Löschen" color="red" @click="remove" class="genBtn" />
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="texts q-pa-lg">
            <h3>{{ project.title }}</h3>
            <p>{{ project.text }}</p>
        </div>
        <div class="column content-center image-container">
            <img
                alt="Bilddarstellung eines Verlinkten Bildes des Projektes"
                v-for="pic in pics"
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
    /* max-width: 80%;
    max-height: 80%; */
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
    background-color: rgb(168, 153, 85);
    border-radius: 15px;
    margin: 10px;
}
.fileele {
    min-height: 50px;
}
</style>
