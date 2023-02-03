<script setup lang="ts">
import type { Ref } from "vue";
import Sidebar from "@/components/Sidebar.vue";
import { ref, onBeforeMount } from "vue";
import { useQuasar } from "quasar";
import Managment from "@/components/Project.vue";
import type { Project } from "@/stores/interfaces";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const $q = useQuasar();
const authStore = useAuthStore();

const selectedProject = ref(null as unknown) as Ref<Project>;
const view = "Project";
async function onProjectChanged(p: Project) {
    selectedProject.value = p;
}

async function check() {
    const answer: boolean = await authStore.check();
    if (answer === false) {
        router.push("/login");
    } else if (authStore.role != "admin") {
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
        <Sidebar @change:selectproject="onProjectChanged" :view="view" />
        <Managment :selectedproject="selectedProject" :view="view" />
    </main>
</template>
<style></style>
