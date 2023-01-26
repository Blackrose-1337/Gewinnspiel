<script setup lang="ts">
import { ref, getCurrentInstance } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar, QEditor } from "quasar";
import { useCompetitionStore } from "@/stores/competition";
import EditorJS from "@editorjs/editorjs";

const $q = useQuasar();
const foreColor = ref("#000000");
const highlight = ref("#ffff00aa");

const token = ref(null);
const color = ref("red");
const editor = new EditorJS("editorjs");

// const { proxy } = getCurrentInstance();

// function color(cmd: any, name: any) {
//     proxy.token.hide();
//     proxy.targetRef.runCmd(cmd, name);
//     proxy.targetRef.focus();
// }

const competitionstore = useCompetitionStore();

const { competition, competitionDetails } = storeToRefs(competitionstore);

function setcolor() {
    navigator.clipboard.writeText("foreColor", false, this.mycolor);
}
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
        {
            label: $q.lang.editor.defaultFont,
            icon: $q.iconSet.editor.font,
            fixedIcon: true,
            list: "no-icons",
            options: [
                "default_font",
                "arial",
                "arial_black",
                "comic_sans",
                "courier_new",
                "impact",
                "lucida_grande",
                "times_new_roman",
                "verdana",
            ],
        },
        "removeFormat",
    ],
    ["unordered", "ordered", "outdent", "indent"],

    ["undo", "redo"],
    ["viewsource"],
];
const fonts = {
    arial: "Arial",
    arial_black: "Arial Black",
    comic_sans: "Comic Sans MS",
    courier_new: "Courier New",
    impact: "Impact",
    lucida_grande: "Lucida Grande",
    times_new_roman: "Times New Roman",
    verdana: "Verdana",
};

async function save() {
    const bool: boolean = await competitionstore.postCompetitiondeclatations();
    console.log(bool);
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
const poppel = function (value: any) {
    console.log(value);
};

const testpoppel: any = {};
</script>

<template>
    <div>
        <div class="q-pa-md">
            <h5>Titel vom Projekt</h5>
            <q-editor v-model="competitionDetails.title" ref="editorRef" :toolbar="toolbar" :fonts="fonts" />

            <h5>Beschreibung Wettbewerb</h5>
            <q-editor v-model="competitionDetails.text" ref="editorRef" :toolbar="toolbar" :fonts="fonts" />
        </div>
        <div bordered elevated class="bg-grey-8k q-pa-md">
            <h5>Teilnahmebedingungen</h5>
            <q-editor
                v-model="competitionDetails.teilnehmerbedingung"
                @update:model-value="value => poppel(value)"
                ref="editorRef"
                :toolbar="toolbar"
                :fonts="fonts"
            >
                <template v-slot:token>
                    <q-btn-dropdown
                        dense
                        no-caps
                        ref="token"
                        no-wrap
                        unelevated
                        color="white"
                        text-color="primary"
                        label="Text Color"
                        size="sm"
                    >
                        <q-list dense>
                            <q-item tag="label" clickable @click="(value: any) => poppel(value)">
                                <q-item-section side>
                                    <q-icon name="highlight" />
                                </q-item-section>
                                <q-item-section>
                                    <q-color
                                        v-model="highlight"
                                        default-view="palette"
                                        no-header
                                        no-footer
                                        :palette="[
                                            '#ffccccaa',
                                            '#ffe6ccaa',
                                            '#ffffccaa',
                                            '#ccffccaa',
                                            '#ccffe6aa',
                                            '#ccffffaa',
                                            '#cce6ffaa',
                                            '#ccccffaa',
                                            '#e6ccffaa',
                                            '#ffccffaa',
                                            '#ff0000aa',
                                            '#ff8000aa',
                                            '#ffff00aa',
                                            '#00ff00aa',
                                            '#00ff80aa',
                                            '#00ffffaa',
                                            '#0080ffaa',
                                            '#0000ffaa',
                                            '#8000ffaa',
                                            '#ff00ffaa',
                                        ]"
                                        class="my-picker"
                                    />
                                </q-item-section>
                            </q-item>
                            <q-item tag="label" v-model="testpoppel" clickable>
                                <q-item-section side>
                                    <q-icon name="format_paint" />
                                </q-item-section>
                                <q-item-section>
                                    <q-color
                                        @update:model-value="(value: any) => poppel(value)"
                                        v-model="foreColor"
                                        no-header
                                        no-footer
                                        default-view="palette"
                                        :palette="[
                                            '#ff0000',
                                            '#ff8000',
                                            '#ffff00',
                                            '#00ff00',
                                            '#00ff80',
                                            '#00ffff',
                                            '#0080ff',
                                            '#0000ff',
                                            '#8000ff',
                                            '#ff00ff',
                                        ]"
                                        class="my-picker"
                                    />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-btn-dropdown>
                </template>
            </q-editor>
            <q-input class="TnB" v-model="competitionDetails.teilnehmerbedingung" />
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
                <q-editor
                    v-model="competitionDetails.wettbewerbCloseText"
                    ref="editorRef"
                    :toolbar="toolbar"
                    :fonts="fonts"
                />
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
</style>
