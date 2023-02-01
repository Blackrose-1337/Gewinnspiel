<script setup lang="ts">
import { computed, onMounted } from "vue";
import type { Auswertung } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";

onMounted(() => {});
</script>
<template>
    <div class="q-pa-md">
        <h3>{{ $route.params.poppel }}</h3>
    </div>
</template>
<style scoped></style>
