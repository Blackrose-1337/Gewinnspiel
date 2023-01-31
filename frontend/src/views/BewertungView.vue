<script setup lang="ts">
import { useRouter } from "vue-router";
import type { Ref } from "vue";
import { ref, onBeforeMount } from "vue";
import Sidebar from "@/components/Sidebar.vue";
import Evaluation from "@/components/Evaluation.vue";
import type { Project } from "@/stores/interfaces";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();

const selectedProject = ref(null as unknown) as Ref<Project>;
const view = "Project";
async function projectChange(p: Project) {
    selectedProject.value = p;
    console.log(p);
}

async function check() {
    const answer: boolean = await authStore.check();
    if (answer == false) {
        router.push("/login");
    }
}

onBeforeMount(() => {
    check();
});
</script>
<template>
    <main class="q-pa-md">
        <Evaluation :project="selectedProject" />
        <Sidebar @change:selectproject="projectChange" :view="view" />
    </main>
</template>
<style></style>
