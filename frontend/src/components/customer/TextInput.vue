<script setup lang="ts">
import { ref, toRefs } from "vue";

import type { Survey, Respond } from "@/stores/interfaces";

//--------------- Props ------------------------------
const props = defineProps<{
    surveyQuestion: Survey;
}>();

const { surveyQuestion } = toRefs(props);

const emit = defineEmits<{
    (event: "change:senden", responds: Respond[]): void;
}>();

//--------------- Store ------------------------------

let userAnswer = ref("");
let respond: Respond = ref({
    question: "",
    answer: "",
});

//--------------- Functions ------------------------------
async function austausch(newanswer: string, questionId: string) {
    // respond.value.question = questionId;
    // respond.value.answer = answer;
    respond.value.question = questionId;
    respond.value.answer = newanswer;
    emit("change:senden", respond);
}

// function updateSelection(answers: Answer[]) {
//     const answer = answers.find(a => a.question === surveyQuestion.value.id);
//     userAnswer.value = answer ? answer.text : "";
// }
//
// updateSelection(answers.value);
// watch(answers, newAnswers => {
//     updateSelection(newAnswers);
// });

// async function handleChange(newText: string) {
//     await customerStore.createOrUpdateAnswer(surveyQuestion?.value.id, newText, []);
// }
</script>
<template>
    <div v-if="surveyQuestion && surveyQuestion.id">
        <h5>{{ surveyQuestion.title }}</h5>
        <p>{{ surveyQuestion.text }}</p>
        <q-input
            v-if="surveyQuestion.typ === 'ML'"
            label="Antwort max. 450 Zeichen"
            filled
            dense
            maxlength="450"
            :debounce="1000"
            v-model="userAnswer"
            @change="austausch(userAnswer, surveyQuestion.id)"
            type="textarea"
        />
        <q-input
            v-if="surveyQuestion.typ === 'SL'"
            label="Antwort max. 150 Zeichen"
            filled
            standout
            dense
            maxlength="150"
            :debounce="1000"
            v-model="userAnswer"
            @change="austausch(userAnswer, surveyQuestion.id)"
        />
    </div>
</template>

<style scoped>
h5 {
    color: #1976d2;
    font-weight: bold;
}
</style>
