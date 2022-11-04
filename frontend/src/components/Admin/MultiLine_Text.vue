<script setup lang="ts">
import { ref, toRefs, watch } from "vue";
import { useSurveyStore } from "@/stores/adminsurvey";
import type { Survey } from "@/stores/interfaces";

interface Props {
    surveyQuestion: Survey;
}
const props = defineProps<Props>();

let { surveyQuestion } = toRefs(props);
const customerStore = useSurveyStore();
let userSelection = ref(surveyQuestion);

async function handleChange() {
    console.log(userSelection.value.title);
    console.log(userSelection.value.text);
    console.log(surveyQuestion.value.id);
    customerStore.changeQuestion(userSelection.value.title, userSelection.value.text, surveyQuestion.value.id);
}
async function remove() {
    customerStore.delete(userSelection.value.id);
    window.location.reload();
}
</script>
<!-----------------HTML-------------------------------->
<template>
    <div class="row" style="width: 100%">
        <div
            class="bg-primary"
            style="padding: 8px; border-radius: 10px; width: 90%"
            v-if="surveyQuestion && surveyQuestion.id"
        >
            <q-input
                class="bg-blue-grey-4"
                style="border-radius: 5px; margin-bottom: -5px"
                outlined
                dense
                :debounce="1000"
                v-model="userSelection.title"
                @update:model-value="handleChange"
                label="Frage Title"
            />
            <br />
            <q-input
                class="bg-blue-grey-4"
                style="border-radius: 5px; margin-top: -5px"
                outlined
                dense
                :debounce="1000"
                v-model="userSelection.text"
                @update:model-value="handleChange"
                label="Fragetext"
            />
        </div>
        <div style="align-self: center">
            <q-btn style="height: 40px; margin-left: 5px" round color="red" icon="remove" @click="remove()"></q-btn>
        </div>
    </div>
    <br />
</template>

<style scoped>
h5 {
    color: #1976d2;
    font-weight: bold;
}
</style>
