<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import Designe from "@/components/Designe.vue"

const router = useRouter();
const route = useRoute();
const view ="Project"
</script>
<template>
    <main class="q-pa-md">
        <Designe />
    </main>
</template>
<style></style>