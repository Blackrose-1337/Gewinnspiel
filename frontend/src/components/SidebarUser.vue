<script setup lang="ts">
import { useProjectStore } from "@/stores/projects";
import { storeToRefs } from "pinia";
import { ref } from "vue";
import type { Project } from "@/stores/interfaces";

//---------------Storeload------------------------------
const projectStore = useProjectStore();

//---------------storeToRefs------------------------------

const { projects } = storeToRefs(projectStore);
let styleId = ref(1);
const emit = defineEmits<{
    (event: "change:selectproject", value: Project): void;
}>();
//---------------Functions------------------------------

function changeSelectProject(pro: Project) {
    emit("change:selectproject", pro);
    styleId.value = pro.id;
}
async function loadProjects() {
    await projectStore.getProjectsUser();
}
defineExpose({ loadProjects });
function load() {
    loadProjects();
}
load();

//---------------Executions------------------------------
</script>
<template>
    <q-drawer show-if-above :breakpoint="700" elevated bordered>
        <q-scroll-area class="fit">
            <!-- Hier wird überprüft ob das Obere Element 'Project' in das view-Element gepackt hat-->
            <q-card bordered>
                <q-card-section color="q-primary" class="full-width q-pa-none">
                    <h4 class="title bg-accent">Project</h4>
                </q-card-section>
                <!-- Ein For-loop um jedes Projekt im Array durchzugehen-->
                <div v-for="pro in projects" :key="pro.id">
                    <div class="full-width q-pa-none">
                        <q-btn
                            class="full-width q-pa-none"
                            bordered
                            :style="{ background: styleId === pro.id ? '#09deed' : '#D9D9D9FF' }"
                            @click="changeSelectProject(pro)"
                            >{{ pro.title }}</q-btn
                        >
                    </div>
                </div>
            </q-card>
        </q-scroll-area>
    </q-drawer>
</template>
<style>
.title {
    background-color: cornflowerblue;
    text-align: center;
    color: black;
    margin-top: -1px;
}
</style>
