<script setup lang="ts">
import { toRefs, watch, computed, ref } from "vue";
import Projectload from "@/components/Project.vue";
import type { Project } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import { useProjectStore } from "@/stores/projects";

const props = defineProps<{
    selectedproject?: Project;
}>();

const evaluationstore = useEvaluationStore();
const projectstore = useProjectStore();
const iniProject = ref(null);

const kriterien = computed(() => evaluationstore.kriterien);

let { selectedproject } = toRefs(props) as Project;
const view = "evaluation";
function update() {
    evaluationstore.update(selectedproject.value.id);
}
function send() {
    evaluationstore.postBewertung();
    projectstore.getProjectsEva();
}

function load() {
    evaluationstore.getKriterien();
}
watch(selectedproject, async changeProject => {
    evaluationstore.bewertung = evaluationstore.bewertung.splice(0, 0);
    await evaluationstore.clear();
    await Promise.all([
        evaluationstore.getall(selectedproject.value.id),
        evaluationstore.getImages(selectedproject.value.id),
        projectstore.setProject(selectedproject.value),
    ]);
    iniProject.value.loadProject();
});
load();
</script>

<template>
    <div class="row q-gutter-lg">
        <div v-if="selectedproject !== null" class="row q-gutter-lg">
            <div class="q-gutter-lg col-6">
                <Projectload ref="iniProject" :view="view" />
            </div>
            <div class="col-5 q-gutter-lg">
                <q-card v-for="k in kriterien" class="q-gutter-lg">
                    <q-card-section>{{ k.frage }}</q-card-section>
                    <q-radio dense v-model="k.value" :val="1" label="1" class="q-pb-md q-px-md" />
                    <q-radio dense v-model="k.value" :val="2" label="2" class="q-pb-md q-px-md" />
                    <q-radio dense v-model="k.value" :val="3" label="3" class="q-pb-md q-px-md" />
                    <q-radio dense v-model="k.value" :val="4" label="4" class="q-pb-md q-px-md" />
                    <q-radio dense v-model="k.value" :val="5" label="5" class="q-pb-md q-px-md" />
                </q-card>
                <div class="row">
                    <q-btn label="Speichern" @click="update">
                      <q-tooltip class="bg-accent">Die Werte werden auf dem Server zwischen gespeichert</q-tooltip>
                    </q-btn>
                    <q-space />
                    <q-btn label="Bewertung Beenden" @click="send">
                      <q-tooltip class="bg-accent">Ausgefühlte Werte werden als Abgeschlossen auf dem Server gespeichert</q-tooltip>
                    </q-btn>
                </div>
            </div>
        </div>

        <div v-else>
            <h2>Wählen Sie ein Projekt zur Bewertung aus</h2>
        </div>
    </div>
</template>

<style></style>
