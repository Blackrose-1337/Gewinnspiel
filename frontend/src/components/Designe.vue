<script setup lang="ts">
import { storeToRefs } from "pinia";
import { useQuasar, QEditor } from "quasar";
import { useCompetitionStore } from "@/stores/competition";
import { onBeforeMount } from "vue";

const $q = useQuasar();
const competitionstore = useCompetitionStore();
const { competition, competitionDetails } = storeToRefs(competitionstore);

const toolbar = [
    [
        {
            label: $q.lang.editor.align,
            icon: $q.iconSet.editor.align,
            fixedLabel: true,
            list: "only-icons",
            options: ["left", "center", "right", "justify"],
        },
    ],
    ["bold", "italic", "strike", "underline", "subscript", "superscript"],
    ["hr"],
    ["token"],
    [
        {
            label: $q.lang.editor.formatting,
            icon: $q.iconSet.editor.formatting,
            list: "no-icons",
            options: ["p", "h1", "h2", "h3", "h4", "h5", "h6"],
        },
        {
            label: $q.lang.editor.fontSize,
            icon: $q.iconSet.editor.fontSize,
            fixedLabel: true,
            fixedIcon: true,
            list: "no-icons",
            options: ["size-1", "size-2", "size-3", "size-4", "size-5", "size-6", "size-7"],
        },
        "removeFormat",
    ],
    ["unordered", "ordered", "outdent", "indent"],

    ["undo", "redo"],
    ["viewsource"],
];

async function save() {
    const bool: boolean = await competitionstore.postCompetitionDeclarations();
    if (bool) {
        $q.notify({
            type: "positive",
            message: "Änderung wurden gespeichert!",
            color: "green",
        });
    } else {
        $q.notify({
            type: "negative",
            message: "Der Speichervorgang ist gescheitert",
            color: "red",
        });
    }
}

async function load() {
    await competitionstore.getCompetitionDeclarations();
}

onBeforeMount(() => {
    load();
});
</script>
<template>
    <div>
        <div class="q-pa-md">
            <h5>Titel vom Gewinnspiel</h5>
            <q-editor v-model="competitionDetails.title" ref="editorRef" :toolbar="toolbar" />
        </div>
        <div class="q-pa-md">
            <h5>Beschreibung Gewinnspiel</h5>
            <q-editor v-model="competitionDetails.text" ref="editorRef" :toolbar="toolbar" />
        </div>
        <div class="bg-grey-8k q-pa-md">
            <h5>Teilnahmebedingungen</h5>
            <q-editor v-model="competitionDetails.teilnehmerbedingung" ref="editorRef" :toolbar="toolbar" />
        </div>
        <div class="bg-grey-8k q-pa-md row">
            <div class="q-pa-md col-3 kalender">
                <h5>Gewinnspielbeginn</h5>
                <q-date color="accent" v-model="competitionDetails.wettbewerbbeginn" />
            </div>
            <div class="q-pa-md col-3 kalender">
                <h5>Gewinnspielende</h5>
                <q-date color="accent" v-model="competitionDetails.wettbewerbende" />
            </div>
            <div class="bg-grey-8k q-pa-md col-5 closetext">
                <h5>Text wenn Gewinnspiel geschlossen ist</h5>
                <q-editor v-model="competitionDetails.wettbewerbCloseText" ref="editorRef" :toolbar="toolbar" />
            </div>
        </div>

        <div class="muh row q-gutter-md q-pb-xl q-pa-md">
            <q-space />
            <q-btn label="Änderungen Speichern" color="accent" @click="save" class="col-2 genBtn" />
        </div>
    </div>
</template>
<style scoped>
.kalender {
    min-width: 300px;
}
.closetext {
    min-width: 600px;
}
@media (max-width: 1300px) {
    .kalender {
        margin: 0 auto;
    }
    .closetext {
        margin: 0 auto;
        width: 100%;
    }
}

#editorjs > div {
    padding: 0 !important;
}
</style>
