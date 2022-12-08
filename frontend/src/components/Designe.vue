<script setup lang="ts">
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import { useCompetitionStore } from "@/stores/competition";

const $q = useQuasar();

const competitionstore = useCompetitionStore();

const { competition, competitionDetails } = storeToRefs(competitionstore);

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
</script>

<template>
    <div>
        <q-input class="q-pa-md" v-model="competitionDetails.title" label="Titel vom Projekt" outlined />

        <div class="q-pa-md">
            <q-input v-model="competitionDetails.text" label="Beschreibung Wettbewerb" outlined autogrow />
        </div>

        <div bordered elevated class="bg-grey-8k q-pa-md">
            <h5>Teilnahmebedingungen</h5>
            <q-input v-model="competitionDetails.teilnehmerbedingung" label="" outlined autogrow />
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
                <q-input v-model="competitionDetails.wettbewerbCloseText" label="" outlined autogrow />
            </div>
        </div>

        <div class="muh row q-gutter-md">
            <q-space />
            <q-btn label="Änderungen Speichern" color="blue" @click="save" class="col-2 rebtn" />
        </div>
    </div>
</template>
