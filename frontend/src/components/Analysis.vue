<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import type { Auswertung } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";

const evaluationstore = useEvaluationStore();
const auswertung = computed(() => evaluationstore.auswertung) as Auswertung;
const missing = computed(() => evaluationstore.missing);
const isLoading = ref(false);

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

async function getmissing() {
	isLoading.value = true;
    await evaluationstore.getmissing();
    isLoading.value = false;
}

onMounted(() => {
    evaluationstore.getAnalysis();
});
</script>
<template>
    <div class="q-pb-xl row">
        <div class="col-8 q-ma-md">
            <q-table
                title="Punkteliste"
                virtual-scroll
                class="my-sticky-virtscroll-table"
                :rows-per-page-options="[0]"
                :rows="auswertung"
                :columns="columns"
                row-key="value"
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

                        <!--                        <p>{{ m.project_ids }}</p>-->
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
