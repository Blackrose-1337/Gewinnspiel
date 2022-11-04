<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import Sidebar from "@/components/Sidebar.vue";
import Formular from "@/components/Formular.vue"
import Managment from "@/components/Project.vue";

const router = useRouter();
const route = useRoute();
const view ="Project"
</script>
<template>
    <main class="q-pa-md">
        <Managment />
        <Sidebar :view="view"/>
    </main>
</template>
<style></style>