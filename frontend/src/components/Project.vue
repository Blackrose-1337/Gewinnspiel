<script setup lang="ts">
import image from "@/components/icons/base64pic.json";
import { propsToAttrMap } from "@vue/shared";
import { useQuasar } from "quasar";
import type { User, Project, ProjectBild } from "@/stores/interfaces";
import { useProjectStore } from "@/stores/projects";
import { toRefs, watch, onMounted, computed, ref } from "vue";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import Loading from "vue-loading-overlay";
const props = defineProps<{
    user?: User;
    selectedproject?: Project;
    view?: string;
}>();

//---------------Storeload------------------------------
const projectStore = useProjectStore();
const evaluationstore = useEvaluationStore();
const $q = useQuasar();

//---------------storeToRefs------------------------------
const project = computed(() => projectStore.project);
let newimage = computed(() => projectStore.newimage);
const img = computed(() => evaluationstore.img);
const { user } = toRefs(props) as User;
const { selectedproject } = toRefs(props) as Project;
const { view } = toRefs(props);
let isLoading = ref(false);
const fullPage = ref(true);
const filesImages = ref();
let previewImage = ref();
const pics = ref([] as string[]);
var bild = new Image();
async function save() {
    const bool: boolean = await projectStore.postProject();
    if (bool == true) {
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
async function remove() {
    const bool: boolean = await projectStore.projectremove(project.value.id);
    if (bool == true) {
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
async function removepic(file: any) {
    const ans = await projectStore.postDeletePic(file.toString());
    if (ans === 1) {
        $q.notify({
            type: "positiv",
            message: `Das Bild wurde gelöscht`,
        });
        loadimage();
    } else {
        $q.notify({
            type: "negative",
            message: `Das Bild wurde nicht gelöscht`,
        });
    }
}

function removeImage(file: any) {
    filesImages.value.splice(filesImages.value.indexOf(file), 1);
}
async function upload() {
    //clear von übertragungs Bilder falls noch von versuch zuvor befüllt
    if (newimage.value.length > 0) {
        newimage.value.splice(0);
    }
    //abfrage ob Bilder hochgeladen wurden falls ja werden diese in Base64 konvertiert
    if (filesImages.value) {
        let promises = [];
        for (let index = 0; index < filesImages.value.length; index++) {
            const element = filesImages.value[index];
            let file = element;
            let reader = new FileReader();
            let promise = new Promise<void>((resolve, reject) => {
                reader.onloadend = function () {
                    const bild: ProjectBild = {
                        id: 0,
                        projectId: project.value.id,
                        bildbase: reader.result as string,
                    };
                    newimage.value.push(bild);
                    console.log(newimage.value);
                    resolve();
                };
                reader.readAsDataURL(file);
            });
            promises.push(promise);
        }
        await Promise.all(promises);
        const ans = await projectStore.postPicupload();
        {
            if (ans === 1) {
                $q.notify({
                    type: "positiv",
                    message: `Das Bild wurde erfolgreich hochgeladen`,
                });
                loadimage();
            } else {
                $q.notify({
                    type: "negative",
                    message: `Das Bild wurde nicht hochgeladen`,
                });
            }
        }
    }
}
function checkFileType(files: any) {
    return files.filter((file: any) => file.type === "image/png" || file.type === "image/jpeg");
}
function onRejected(rejectedEntries: any) {
    $q.notify({
        type: "negative",
        message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
    });
}
async function load() {
    isLoading.value = true;
    if (user.value == null) {
    } else {
        projectStore.clear();
        await projectStore.getProject(user.value.id);
        await loadimage();
    }
}
async function loadimage() {
    isLoading.value = true;
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
async function loadProject() {
    pics.value = [];
    isLoading.value = true;
    projectStore.setProject(selectedproject.value);
    await evaluationstore.getImages(selectedproject.value.id);
    projectStore.clear();
    project.value.pics = evaluationstore.img;
    await loadimage();
}

function showImage(image: any) {
    previewImage.value = image;
}
function hideImage() {
    previewImage.value = null;
}
watch(user, changeuser => {
    load();
});
onMounted(() => {
    if (view?.value !== "Project" && view?.value !== "evaluation") {
        if (typeof user.value.id == "undefined") {
        } else {
            load();
        }
    } else {
    }
});
watch(selectedproject, changeselectedproject => {
    loadProject();
});
</script>
<template>
    <loading
        :active.sync="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.021)"
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
                class="picloader"
                v-model="filesImages"
                rounded
                outlined
                append
                use-chips
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
                        <q-avatar size="50px" icon="description" text-color="blue" color="white"> </q-avatar>
                        {{ file.name }}
                        <q-space />
                        <q-btn class="fileele q-pa-sm" flat icon="delete" @click="removeImage(file)" />
                    </q-chip>
                </template>
            </q-file>
            <q-btn round dense flat icon="upload" @click="upload()" />
        </div>
        <div class="image-container q-pa-sm test">
            <div v-for="pic in pics" class="row">
                <img :src="pic" @click="showImage(pic)" />
                <q-btn class="fileele" flat icon="delete" @click="removepic(pic)" />
                <br />
            </div>
            <div class="image-preview" v-if="previewImage" @click="hideImage()">
                <img :src="previewImage" @click="hideImage()" />
            </div>

            <!-- <q-file
                class="picloader"
                v-model="bsp"
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
                    <div class="row full-width">
                        <div class="col-2">
            
                            <q-avatar rounded>
                                <img :src="file.toString()" />
                            </q-avatar>
                           
                        </div>
                        <div class="col-8">
                            <q-chip class="fileele full-width q-my-xs" square>
                                {{ file.toString().split("/")[file.toString().split("/").length - 1] }}
                                <q-space />
                                <q-btn class="fileele q-pa-sm" flat icon="delete" @click="removepic(file)" />
                            </q-chip>
                        </div>
                    </div>
                </template>
            </q-file> -->
        </div>

        <div v-if="view == 'Project'">
            <q-btn label="Änderungen Speichern" color="blue" @click="save" class="rebtn" />
        </div>
        <div v-if="view == 'Project'">
            <q-btn label="Projekt Löschen" color="red" @click="remove" class="rebtn" />
        </div>
    </div>
    <div v-else>
        <div class="texts q-pa-lg">
            <h3>{{ project.title }}</h3>
            <p>{{ project.text }}</p>
        </div>
        <div class="image-container test">
            <img v-for="pic in pics" :src="pic" @click="showImage(pic)" />
            <div class="image-preview" v-if="previewImage" @click="hideImage">
                <img :src="previewImage" @click="hideImage" />
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
.test {
    align-items: center;
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
