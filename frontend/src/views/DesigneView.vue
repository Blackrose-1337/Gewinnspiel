<script setup lang="ts">
import { onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import Designe from "@/components/Designe.vue";
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
    <main class="q-pa-md">
        <Designe />
    </main>
</template>
<style></style>
