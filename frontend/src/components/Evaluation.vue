<script setup lang="ts">
import { ref } from "vue";
import Project from "@/components/Project.vue";

const model = ref(null);

const fragen: String[] = ["Wie ist die Stoffwahl?", "Wie ist das Stickmuster?"];

</script>

<template>
    <div class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Project />
        </div>
        <div class="col-5 q-gutter-lg">
            <div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde rerum consectetur ipsam id natus
                    exercitationem quae, error, fugit rem dolor numquam accusamus placeat cupiditate repudiandae modi
                    blanditiis? Saepe, corporis libero? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Iste
                    quis,
                </p>
            </div>
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

<style>

</style>