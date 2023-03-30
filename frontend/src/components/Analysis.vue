<script setup lang="ts">
import { computed, onMounted } from "vue";
import type { Auswertung } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";

const evaluationstore = useEvaluationStore();
const auswertung = computed(() => evaluationstore.auswertung) as Auswertung;
const missing = computed(() => evaluationstore.missing);

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
function getmissing() {
    evaluationstore.getmissing();
}
onMounted(() => {
    evaluationstore.getAnalysis();
});
</script>
<template>
    <div class="row q-ma-md">
        <q-table class="col-8 q-ma-md" title="Punkteliste" :rows="auswertung" :columns="columns" row-key="name" />
        <q-space />
        <div class="q-ma-xl col-2">
            <q-btn @click="getmissing" class="full-width genBtn" label="Fehlende Bewertungen anzeigen"/>
            <q-card>
                <div class="q-mt-md" v-for="m in missing" :key="m">
                    <q-card-section class="bg-amber-1">
                        <h6>{{ m.name }} {{ m.surname }}</h6>
                        <p>{{ m.project_ids }}</p>
                    </q-card-section>
                </div>
            </q-card>
        </div>
    </div>
</template>
<style scoped></style>
