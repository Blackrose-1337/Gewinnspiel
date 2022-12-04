<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import Competition from "@/components/Competition.vue";

const router = useRouter();
const route = useRoute();
</script>
<template>
    <q-page>
        <Competition />
    </q-page>
</template>
<style></style>
