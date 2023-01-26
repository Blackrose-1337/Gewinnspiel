<script setup lang="ts">
import { onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();

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
    <main class="q-pa-md">< /></main>
</template>
<style></style>
