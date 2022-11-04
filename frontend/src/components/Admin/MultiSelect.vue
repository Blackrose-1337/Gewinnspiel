<script setup lang="ts">
import { useRoute, useRouter } from "vue-router";
import { ref } from "vue";

//---------------Routload------------------------------

const router = useRouter();
const route = useRoute();

//---------------Functions------------------------------

let options = ref([
    {
        label: "Option " + 1,
        id: 1,
        value: 0,
    },
]);

let userSelection = [{ selected: ref(12) }];
const Quantity = ref(options.value.length);

function setCheckbox() {
    if (Quantity.value < options.value.length) {
        options.value.splice(Quantity.value); // Entfernt Array ab der angebenen grösse
    }
    for (let i = 0; i < Quantity.value; i++) {
        if (i + 1 > options.value.length) {
            options.value.push({
                label: "Option " + (i + 1),
                id: i + 1,
                value: 0,
            });
        }
    }
}

function add() {
    Quantity.value++;
    console.log("Quantity: " + Quantity.value);
    options.value.push({
        label: "Option " + Quantity.value,
        id: Quantity.value,
        value: 0,
    });
}
function remove(index: any) {
    let test = options.value.indexOf(index);
    options.value.splice(test, 1);
}
</script>
<!-----------------HTML-------------------------------->
<template>
    <div class="ValueRangeEdit">
        <h5>Mehrfachauswahl</h5>
        <br />
        <div class="inline-block">
            <q-input
                style="min-width: 150px; padding: 10px"
                type="number"
                v-model.number="Quantity"
                @update:model-value="setCheckbox()"
                :min="1"
                :max="9999"
                label="Anzahl Buttons"
                input-class="text-right"
                outlined
                rounded
                virtual-scroll-slice-ratio-before="0.3"
            />
        </div>
        <div class="row" v-for="option in options" :key="option.id">
            <q-checkbox dense class="col-1" v-model="userSelection" />
            <q-input outlined class="col-7" v-model="option.label" label="Bezeichnung"> </q-input>
            <q-input type="number" outlined class="col-2" v-model="option.value" label="Set Value"></q-input>
            <div class="col-2">
                <q-btn
                    style="align-content: center; margin: 6px"
                    round
                    color="red"
                    icon="remove"
                    @click="remove(option)"
                ></q-btn>
            </div>
        </div>
        <div class="row justify-center" style="margin: 10px">
            <q-btn round color="green" icon="add" @click="add()"></q-btn>
        </div>
        {{ options }}
        {{ userSelection }}
    </div>
</template>

<style scoped>
h5 {
    color: #1976d2;
    font-weight: bold;
}
.col-1 {
    height: 60px;
    padding: 0;
}
.col-7 {
    height: 60px;
    padding: 0;
}
.col-2 {
    height: 60px;
    padding-left: 10px;
}
</style>
