<script setup lang="ts">
import { useRouter } from "vue-router";
import type { Ref } from "vue";
import { useQuasar } from "quasar";
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
}

const $q = useQuasar();
async function check() {
    const answer: boolean = await authStore.check();
    if (answer === false) {
        router.push("/login");
    } else if (authStore.role == "jury" || authStore.role == "admin") {
    } else {
        $q.notify({
            type: "negative",
            message: "Keine Berechtigung für diese Seite",
            color: "red",
        });
        router.push("/");
    }
}

onBeforeMount(() => {
    check();
});
</script>
<template>
    <main class="q-pa-md">
        <Evaluation :selectedproject="selectedProject" />
        <Sidebar @change:selectproject="projectChange" :view="view" />
    </main>
</template>
<style></style>
