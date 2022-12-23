<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import type { Ref } from "vue";
import { ref } from "vue";
import Sidebar from "@/components/Sidebar.vue";
import Evaluation from "@/components/Evaluation.vue";
import type { Project } from "@/stores/interfaces";

const router = useRouter();
const route = useRoute();
const selectedProject = ref(null as unknown) as Ref<Project>;
const view = "Project";
async function projectChange(p: Project) {
    selectedProject.value = p;
}
</script>
<template>
    <main class="q-pa-md">
        <Evaluation :project="selectedProject" />
        <Sidebar @change:selectproject="projectChange" :view="view" />
    </main>
</template>
<style></style>
