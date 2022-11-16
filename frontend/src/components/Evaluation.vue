<script setup lang="ts">
import { ref, toRefs, watch } from "vue";
import Projectload from "@/components/Project.vue";
import type { Project } from "@/stores/interfaces";

const props = defineProps<{
    project?: Project;
}>();

let { project } = toRefs(props) as Project;
const view = "evaluation";
const model = ref(null);

const fragen: String[] = ["Wie ist die Stoffwahl?", "Wie ist das Stickmuster?"];
</script>

<template>
    <div class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Projectload :selectedproject="project" :view="view" />
        </div>
        <div class="col-5 q-gutter-lg">
            <q-card v-for="frage in fragen" class="q-gutter-lg">
                <q-card-section>{{ frage }}</q-card-section>
                <q-radio dense v-model="model" val="1" label="1" class="q-pb-md q-px-md" />
                <q-radio dense v-model="model" val="2" label="2" class="q-pb-md q-px-md" />
                <q-radio dense v-model="model" val="3" label="3" class="q-pb-md q-px-md" />
                <q-radio dense v-model="model" val="4" label="4" class="q-pb-md q-px-md" />
                <q-radio dense v-model="model" val="5" label="5" class="q-pb-md q-px-md" />
            </q-card>
            <div class="row">
                <q-btn>Speichern</q-btn>
                <q-space />
                <q-btn>Bewertung Beenden</q-btn>
            </div>
        </div>
    </div>
</template>

<style></style>
