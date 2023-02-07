<script setup lang="ts">
import { ref, getCurrentInstance } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar, QEditor } from "quasar";
import { useCompetitionStore } from "@/stores/competition";

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
    const bool: boolean = await competitionstore.postCompetitiondeclatations();
    if (bool == true) {
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
    await competitionstore.getCompetitiondeclarations();
}

load();
</script>
<template>
    <div>
        <div class="q-pa-md">
            <h5>Titel vom Projekt</h5>
            <q-editor v-model="competitionDetails.title" ref="editorRef" :toolbar="toolbar" />
        </div>
        <div class="q-pa-md">
            <h5>Beschreibung Wettbewerb</h5>
            <q-editor v-model="competitionDetails.text" ref="editorRef" :toolbar="toolbar" />
        </div>
        <div bordered elevated class="bg-grey-8k q-pa-md">
            <h5>Teilnahmebedingungen</h5>
            <q-editor v-model="competitionDetails.teilnehmerbedingung" ref="editorRef" :toolbar="toolbar" />
        </div>
        <div bordered elevated class="bg-grey-8k q-pa-md row">
            <div class="q-pa-md col-3">
                <h5>Wettbewerbbeginn</h5>
                <q-date v-model="competitionDetails.wettbewerbbeginn" />
            </div>
            <div class="q-pa-md col-3">
                <h5>Wettbewerbende</h5>
                <q-date v-model="competitionDetails.wettbewerbende" />
            </div>
            <div bordered elevated class="bg-grey-8k q-pa-md col-5">
                <h5>Text wenn Wettbewerb geschlossen ist</h5>
                <q-editor v-model="competitionDetails.wettbewerbCloseText" ref="editorRef" :toolbar="toolbar" />
            </div>
        </div>

        <div class="muh row q-gutter-md">
            <q-space />
            <q-btn label="Änderungen Speichern" color="blue" @click="save" class="col-2 rebtn" />
        </div>
    </div>
</template>
<style scoped>
.my-picker {
    max-width: 150px;
}
@media (max-width: 1300px) {
    .row > .col-3,
    .row > .col-xs-3 {
        min-width: 320px;
        height: auto;
        width: 25%;
    }
    .row > .col-5,
    .row > .col-xs-5 {
        height: auto;
        width: auto;
    }
}
#editorjs {
    background-color: rgb(241, 241, 241);
    margin: 15px;
    border-radius: 5px;
    border: solid rgb(104, 104, 104) 3px;
    align-items: left;
    align-self: left;
}
#editorjs > div {
    padding: 0 !important;
}
.div.codex-editor__redactor {
    padding-bottom: 20px;
}
</style>
