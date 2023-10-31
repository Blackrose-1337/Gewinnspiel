<script setup lang="ts">
import { toRefs, watch, computed, ref } from "vue";
import Projectload from "@/components/Project.vue";
import { useQuasar } from "quasar";
import type { Project } from "@/stores/interfaces";
import { useEvaluationStore } from "@/stores/evaluation.ts";
import { useProjectStore } from "@/stores/projects";
import { useAuthStore } from "@/stores/auth";

const props = defineProps<{
    selectedproject?: Project;
}>();

const $q = useQuasar();
const authStore = useAuthStore();
const evaluationStore = useEvaluationStore();
const projectStore = useProjectStore();
const iniProject = ref(null);
let isLoading = ref(false);

const kriterien = computed(() => evaluationStore.kriterien);
const role = computed(() => authStore.role);

let { selectedproject } = toRefs(props) as Project;
const view = "evaluation";
async function update() {
    isLoading.value = true;
    const ans = await evaluationStore.update(selectedproject.value.id);
    if (ans) {
        await projectStore.getProjectsEva();
        $q.notify({
            type: "positive",
            message: "Bewertung wurde zwischengespeichert",
            color: "green",
        });
    } else {
        $q.notify({
            type: "negative",
            message: "Bewertung konnte nicht zwischengespeichert werden",
            color: "red",
        });
    }
    isLoading.value = false;
}

async function send() {
    isLoading.value = true;
    const ans = await evaluationStore.postBewertung(selectedproject.value.id);
    if (ans) {
        await projectStore.getProjectsEva();
        $q.notify({
            type: "positive",
            message: "Bewertung wurde gespeichert",
            color: "green",
        });
    } else {
        $q.notify({
            type: "negative",
            message: "Bewertung konnte nicht gespeichert werden",
            color: "red",
        });
    }
    isLoading.value = false;
}

function load() {
    evaluationStore.getKriterien();
}
watch(selectedproject, async changeProject => {
    evaluationStore.bewertung = evaluationStore.bewertung.splice(0, 0);
    await evaluationStore.clear();
    await Promise.all([
        evaluationStore.getall(selectedproject.value.id),
        evaluationStore.getImages(selectedproject.value.id),
        projectStore.setProject(selectedproject.value),
    ]);
    iniProject.value.loadProject();
});
load();
</script>

<template>
    <div class="row q-gutter-lg">
        <div v-if="selectedproject !== null" class="row full-width q-gutter-lg">
            <div class="q-gutter-lg col-6" id="zentrierer">
                <Projectload ref="iniProject" :view="view" />
            </div>
            <div v-if="role === 'jury'" id="zentrierer" class="col-5 q-gutter-lg">
                <q-card v-for="k in kriterien" :key="k" class="q-gutter-lg">
                    <q-card-section>{{ k.frage }}</q-card-section>
                    <q-radio dense color="accent" v-model="k.value" :val="1" label="1" class="q-pb-md q-px-md" />
                    <q-radio dense color="accent" v-model="k.value" :val="2" label="2" class="q-pb-md q-px-md" />
                    <q-radio dense color="accent" v-model="k.value" :val="3" label="3" class="q-pb-md q-px-md" />
                    <q-radio dense color="accent" v-model="k.value" :val="4" label="4" class="q-pb-md q-px-md" />
                    <q-radio dense color="accent" v-model="k.value" :val="5" label="5" class="q-pb-md q-px-md" />
                </q-card>
                <div class="row q-pb-xl">
                    <q-btn :loading="isLoading" color="green-5" label="Speichern" @click="update">
                        <q-tooltip class="bg-accent">Die Bewertung wird zwischengespeichert</q-tooltip>
                    </q-btn>
                    <q-space />
                    <q-btn :loading="isLoading" :disable="isLoading" color="green-5" label="Als bewertet markieren" @click="send">
                        <q-tooltip class="bg-accent">Bewertung wird final abgeschlossen</q-tooltip>
                    </q-btn>
                </div>
            </div>
            <div v-else id="zentrierer" class="col-5 q-gutter-lg">
                <q-card v-for="k in kriterien" :key="k" class="q-gutter-lg bewertungcards">
                    <q-card-section>{{ k.frage }}</q-card-section>
                    <q-radio
                        disable
                        dense
                        color="accent"
                        v-model="k.value"
                        :val="1"
                        label="1"
                        class="q-pb-md q-px-md"
                    />
                    <q-radio
                        disable
                        dense
                        color="accent"
                        v-model="k.value"
                        :val="2"
                        label="2"
                        class="q-pb-md q-px-md"
                    />
                    <q-radio
                        disable
                        dense
                        color="accent"
                        v-model="k.value"
                        :val="3"
                        label="3"
                        class="q-pb-md q-px-md"
                    />
                    <q-radio
                        disable
                        dense
                        color="accent"
                        v-model="k.value"
                        :val="4"
                        label="4"
                        class="q-pb-md q-px-md"
                    />
                    <q-radio
                        disable
                        dense
                        color="accent"
                        v-model="k.value"
                        :val="5"
                        label="5"
                        class="q-pb-md q-px-md"
                    />
                </q-card>
                <div class="row q-pb-xl">
                    <q-btn :loading="isLoading" disable color="green-5" label="Speichern" @click="update">
                        <q-tooltip class="bg-accent">Die Bewertung wird zwischengespeichert</q-tooltip>
                    </q-btn>
                    <q-space />
                    <q-btn :loading="isLoading" disable color="green-5" label="Als bewertet markieren" @click="send">
                        <q-tooltip class="bg-accent">Bewertung wird final abgeschlossen</q-tooltip>
                    </q-btn>
                </div>
            </div>
        </div>

        <div v-else>
            <h2>Wählen Sie ein Projekt zur Bewertung aus</h2>
        </div>
    </div>
</template>

<style scoped>
.bewertungcards {
    min-width: 300px;
}
@media (max-width: 1200px) {
    #zentrierer {
        min-width: 400px;
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
    }
}
</style>
