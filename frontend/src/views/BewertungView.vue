<script setup lang="ts">
import { useRouter } from "vue-router";
import type { Ref } from "vue";
import { useQuasar } from "quasar";
import { ref, onBeforeMount } from "vue";
import Sidebar from "@/components/Sidebar.vue";
import Evaluation from "@/components/EvaluationItem.vue";
import type { Project } from "@/stores/interfaces";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();

const selectedProject = ref(null as unknown) as Ref<Project>;
const view = "Evaluation";
async function projectChange(p: Project) {
    selectedProject.value = p;
}

const $q = useQuasar();
async function check() {
    const answer: boolean = await authStore.check();
    if (!answer) {
        await router.push("/");
        $q.notify({
            type: "negative",
            message: "Keine Berechtigung für diese Seite",
            color: "red",
        });
    }
}

onBeforeMount(() => {
    check();
});
</script>
<template>
    <main class="q-pa-md">
        <q-card style="max-width: 350px" class="q-mb-md q-mx-auto transition-0 bg-accent fa-border">
            <div class="row">
                <q-space />
                <q-icon size="md" class="q-ma-xs" name="info" />
            </div>
            <div class="q-mx-auto">
                <q-item header class="text-h6 justify-center">Je mehr Punkte, desto Besser.</q-item>
            </div>
        </q-card>
        <Evaluation :selectedproject="selectedProject" class="spacing" />
        <Sidebar @change:selectproject="projectChange" :view="view" />
    </main>
</template>
<style scoped>
.spacing {
    margin-right: 24px;
}
</style>
