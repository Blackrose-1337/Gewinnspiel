<script setup lang="ts">
import image from "@/components/icons/base64pic.json";
import { propsToAttrMap } from "@vue/shared";
import { useQuasar } from "quasar";
import type { User, Project } from "@/stores/interfaces";
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
const img = computed(() => evaluationstore.img);
const { user } = toRefs(props) as User;
const { selectedproject } = toRefs(props) as Project;
const { view } = toRefs(props);
let isLoading = ref(false);
const fullPage = ref(true);

const bsp: string[] = ref([]) as unknown as string[];
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

async function load() {
    isLoading.value = true;
    if (user.value == null) {
    } else {
        projectStore.clear();
        await projectStore.getProject(user.value.id);
        loadimage();
    }
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
}
function loadimage() {
    bsp.value = [];
    if (project.value.pics !== null && project.value.pics !== "undefined") {
        project.value.pics.forEach((e: { img: string }) => {
            bild.src = e.img;
            bsp.value.push(bild.src);
        });
    }
}

async function loadProject() {
    bsp.value = [];
    isLoading.value = true;
    projectStore.setProject(selectedproject.value);
    await evaluationstore.getImages(selectedproject.value.id);
    projectStore.clear();
    project.value.pics = evaluationstore.img;
    loadimage();
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
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
    <loading :active.sync="isLoading" :can-cancel="true" :is-full-page="fullPage"></loading>
    <div v-if="view === 'Project' || view === 'User'">
        <div>
            <h4 class="q-ma-md">Projekttitle</h4>
            <q-input v-model="project.title" outlined class="q-ma-md" />
            <h4 class="q-ma-md">Projekttext</h4>
            <q-input v-model="project.text" outlined class="q-ma-md" autogrow />
        </div>
        <div class="row q-gutter-lg pic">
            <img v-for="pic in bsp" class="minipic q-pa-md" :src="pic" :ratio="1" @click="expand($event)" />
        </div>

        <div v-if="view == 'Project'">
            <q-btn label="Änderungen Speichern" color="blue" @click="save" class="rebtn" />
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
                v-for="pic in bsp"
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
    height: 20vh;

    box-shadow: 0 1px 5px rgb(0 0 0 / 20%), 0 2px 2px rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%);
    /* min-height: 24px;
    min-width: 24px; */
    align-self: center;
    z-index: 999;
}

.fullimage {
    width: 100% !important;
    height: 100% !important;
    display: flex;
    position: absolute;
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
    height: 90vh;
    width: 90vw;

    animation: expander 0.5s;
    position: fixed;
    left: 0;
    right: 0;
    top: 8vh;
    bottom: 0;
    margin: auto;
    z-index: 9999;
}
.reexpandanimation {
    height: 20vh;
    width: 20vw;

    animation: reexpander 0.3s;
}

@keyframes expander {
    0% {
        width: 20vw;
        height: 20vh;
    }
    100% {
        width: 90vw;
        height: 90vh;
    }
}
@keyframes reexpander {
    100% {
        width: 20vw;
        height: 20vh;
    }
}
</style>
