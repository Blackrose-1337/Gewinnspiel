<script setup lang="ts">
import { onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import { useAuthStore } from "@/stores/auth";
import Auswertung from "@/components/Analysis.vue";

const router = useRouter();
const authStore = useAuthStore();

const $q = useQuasar();
async function check() {
    const answer: boolean = await authStore.check();
    if (!answer) {
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
        <Auswertung />
    </main>
</template>
<style></style>
