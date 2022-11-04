<script setup lang="ts">
import { useRoute, useRouter } from "vue-router";
import { ref } from "vue";
import { id } from "date-fns/locale";

//---------------Routload------------------------------
const router = useRouter();
const route = useRoute();

//---------------Variables------------------------------

let options = ref([
    {
        label: "Option 1",
        id: 1,
        value: 0,
    },
]);

const Quantity = ref(options.value.length);
let userSelection = ref("op1");

//---------------Functions------------------------------
function setButtons() {
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
        <h5>Einzelauswahl</h5>
        <br />
        <br />

        <div class="row justify-center" v-for="option in options" :key="option.id">
            <q-radio dense class="col-1" v-model="userSelection" :val="option.id" />
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

        <br />
        {{ options }}
        {{ userSelection }}
        <q-input v-model="options[0].label"></q-input>
    </div>
</template>

<style scoped>
h5 {
    color: #1976d2;
    font-weight: bold;
}

.col-7 {
    height: 60px;
    padding: 0;
}
.col-2 {
    height: 60px;
    padding-left: 10px;
}
.col-1 {
    height: 60px;
    padding: 0;
}
</style>
