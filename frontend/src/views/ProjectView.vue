<script setup lang="ts">
import type { Ref } from "vue";
import { ref, onBeforeMount } from "vue";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";
import Managment from "@/components/Project.vue";
import Sidebar from "@/components/Sidebar.vue";
import type { Project } from "@/stores/interfaces";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const $q = useQuasar();
const authStore = useAuthStore();

const selectedProject = ref(null as unknown) as Ref<Project>;
async function onProjectChanged(p: Project) {
    selectedProject.value = p;
}

async function check() {
    const answer: boolean = await authStore.check();
    if (!answer) {
        await router.push("/login");
    } else if (authStore.role != "admin") {
        $q.notify({
            type: "negative",
            message: "Keine Berechtigung für diese Seite",
            color: "red",
        });
        await router.push("/");
    }
}

onBeforeMount(() => {
    check();
});
</script>
<template>
    <main class="q-pa-md">
        <Sidebar @change:selectproject="onProjectChanged" ref="sidebarRef?" :view="'Project'" />
        <Managment :selectedproject="selectedProject" :view="'Project'" />
    </main>
</template>
<style></style>
