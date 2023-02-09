<script setup lang="ts">
import { computed, onMounted } from "vue";
import type { Auswertung } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";

const evaluationstore = useEvaluationStore();
const auswertung = computed(() => evaluationstore.auswertung) as Auswertung;

const columns = [
    {
        name: "surname",
        required: true,
        label: "Nachname",
        align: "left",
        field: "surname",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    { name: "name", align: "left", label: "Vorname", field: "name", sortable: true },
    { name: "mail", label: "E-mail", field: "mail", sortable: true },
    { name: "value", label: "Gesamtpunkte", field: "value", sortable: true },
];
onMounted(() => {
    evaluationstore.getAnalysis();
});
</script>
<template>
    <div class="q-pa-md">
        <q-table title="Punkteliste" :rows="auswertung" :columns="columns" row-key="name" />
    </div>
</template>
<style scoped></style>
