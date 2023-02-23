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
const newimage = computed(() => projectStore.newimage);
const img = computed(() => evaluationstore.img);
const { user } = toRefs(props) as User;
const { selectedproject } = toRefs(props) as Project;
const { view } = toRefs(props);
let isLoading = ref(false);
const fullPage = ref(true);
const filesImages = ref();
const pics: string[] = ref([]) as unknown as string[];
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
}
function removeImage(file: any) {
    filesImages.value.splice(filesImages.value.indexOf(file), 1);
}
async function upload() {
    //clear von übertragungs Bilder falls noch von versuch zuvor befüllt
    newimage.value.pics.splice(0);
    //abfrage ob Bilder hochgeladen wurden falls ja werden diese in Base64 konvertiert
    if (filesImages.value) {
        for (let index = 0; index < filesImages.value.length; index++) {
            const element = filesImages.value[index];
            let file = element;
            let reader = new FileReader();
            reader.onloadend = function () {
                const bild: ProjectBild = {
                    id: 0,
                    projectId: project.value.id,
                    bildbase: reader.result as string,
                };
                newimage.value.pics.push(bild);
            };
            reader.readAsDataURL(file);
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
function expand($event: any) {
    if ($event.target.classList.contains("expandanimation")) {
        $event.target.classList.remove("expandanimation");
        $event.target.classList.add("reexpandanimation");
    } else {
        $event.target.classList.remove("reexpandanimation");
        $event.target.classList.add("expandanimation");
    }
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
        <div v-for="pic in pics" class="row q-gutter-lg pic">
            <img class="minipic q-pa-md" :src="pic" :ratio="1" />
            <q-btn class="fileele q-pa-sm" flat icon="delete" @click="removepic(pic)" />

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
        <div class="row q-gutter-lg pic">
            <img
                spinner-color="green"
                v-for="pic in pics"
                class="minipic q-pa-md"
                :src="pic"
                :ratio="1"
                @click="expand($event)"
            />
        </div>
    </div>
</template>

<style>
.minipic {
    width: 20vw;

    box-shadow: 0 1px 5px rgb(0 0 0 / 20%), 0 2px 2px rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%);
    /* min-height: 24px;
    min-width: 24px; */
    align-self: center;
    aspect-ratio: auto;
    z-index: 999;
}

.texts {
    background-color: rgb(168, 153, 85);
    border-radius: 15px;
    margin: 10px;
}
.pic {
    margin: 5px;
}
.expandanimation {
    max-width: 100vw;
    width: 70vw;
    height: auto;

    animation: expander 1.5s;
    aspect-ratio: auto;
    position: fixed;
    left: 0;
    right: 0;
    top: 8vh;
    bottom: 0;
    margin: auto;
    z-index: 9999;
}

.reexpandanimation {
    aspect-ratio: auto;
    width: 20vw;
    animation: reexpander 0.3s;
}
@keyframes expander {
    0% {
        width: 20vw;
    }
    100% {
        width: 70vw;
    }
}
@keyframes reexpander {
    100% {
        width: 20vw;
    }
}
.fileele {
    min-height: 50px;
}
</style>
