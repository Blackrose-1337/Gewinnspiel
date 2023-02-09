<script setup lang="ts">
import { toRefs, watch, computed } from "vue";
import Projectload from "@/components/Project.vue";
import type { Project } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";

const props = defineProps<{
    project?: Project;
}>();

const evaluationstore = useEvaluationStore();

const kriterien = computed(() => evaluationstore.kriterien);

let { project } = toRefs(props) as Project;
const view = "evaluation";
function update() {
    evaluationstore.update(project.value.id);
}
function send() {
    evaluationstore.postBewertung();
}

function load() {
    evaluationstore.getKriterien();
}
watch(project, changeProject => {
    evaluationstore.bewertung = evaluationstore.bewertung.splice(0, 0);
    evaluationstore.clear();
    evaluationstore.getall(changeProject.id);
});
load();
</script>

<template>
    <div class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Projectload :selectedproject="project" :view="view" />
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
                <q-btn label="Speichern" @click="update" />
                <q-space />
                <q-btn label="Bewertung Beenden" @click="send" />
            </div>
        </div>
    </div>
</template>

<style></style>
