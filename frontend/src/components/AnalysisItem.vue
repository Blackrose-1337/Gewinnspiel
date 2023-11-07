<script setup lang="ts">
import { computed, onBeforeMount, ref } from "vue";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import Loading from "vue-loading-overlay";

const evaluationstore = useEvaluationStore();
const auswertung = computed(() => evaluationstore.auswertung);
const missing = computed(() => evaluationstore.missing);
const isLoading = ref(false);
const fullPage = ref(true);

const columns = [
    {
        name: "surname",
        required: true,
        label: "Nachname",
        align: "left",
        field: "surname",
        format: (val: never) => `${val}`,
        sortable: true,
    },
    { name: "name", align: "left", label: "Vorname", field: "name", sortable: true },
    { name: "mail", label: "E-mail", field: "mail", sortable: true },
    { name: "value", label: "Gesamtpunkte", field: "value", sortable: true },
];

async function getmissing() {
    isLoading.value = true;
    await evaluationstore.getmissing();
    isLoading.value = false;
}

async function load() {
    isLoading.value = true;
    await evaluationstore.getAnalysis();
    isLoading.value = false;
}
onBeforeMount(async () => {
    await load();
});
</script>
<template>
    <loading
        v-model="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.223)"
        :can-cancel="true"
        :is-full-page="fullPage"
    ></loading>
    <div class="q-pb-xl row">
        <div v-if="!isLoading && auswertung && columns" class="col-8 q-ma-md">
            <q-table
                title="Punkteliste"
                virtual-scroll
                class="my-sticky-virtscroll-table"
                :rows="auswertung"
                :columns="columns"
                row-key="id"
            />
        </div>
        <q-space />
        <div class="m-list q-ma-lg col-2">
            <q-btn
                @click="getmissing"
                :loading="isLoading"
                class="full-width genBtn"
                label="Fehlende Bewertungen anzeigen"
            />
            <q-card>
                <div class="q-mt-md" v-for="m in missing" :key="m">
                    <q-card-section class="bg-primary">
                        <h6>{{ m.name }} {{ m.surname }}</h6>
                        <div class="row">
                            <div class="q-pa-sm" v-for="p in m.project_ids" :key="p">
                                <q-card class="col-3">{{ p }}</q-card>
                            </div>
                        </div>
                    </q-card-section>
                </div>
            </q-card>
        </div>
    </div>
</template>
<style scoped>
.m-list {
    min-width: 300px;
}
.my-sticky-virtscroll-table {
    max-height: 60vh;
}
</style>
