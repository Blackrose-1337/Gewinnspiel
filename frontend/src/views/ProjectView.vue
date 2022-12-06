<script setup lang="ts">
import type { Ref } from "vue";
import Sidebar from "@/components/Sidebar.vue";
import { ref, toRefs, watch } from "vue";
import Formular from "@/components/Formular.vue";
import Managment from "@/components/Project.vue";
import type { Project } from "@/stores/interfaces";

const selectedProject = ref(null as unknown) as Ref<Project>;
const view = "Project";
async function onProjectChanged(p: Project) {
    console.log("Project: ", p);
    selectedProject.value = p;
}
</script>
<template>
    <main class="q-pa-md">
        <Sidebar @change:selectproject="onProjectChanged" :view="view" />
        <Managment :selectedproject="selectedProject" :view="view" />
    </main>
</template>
<style></style>
