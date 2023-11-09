<script setup lang="ts">
import { onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import Auswertung from "@/components/AnalysisItem.vue";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();

const $q = useQuasar();
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
        <Auswertung />
    </main>
</template>
<style></style>
