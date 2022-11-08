<script setup lang="ts">
import { ref, watch } from "vue";
import { toRefs } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import type {User} from "@/stores/interfaces"

const props = defineProps<{
    user?: User
}>();
const emit = defineEmits<{
    (event: "change:declarations", u : User ): void;
}>();
const { user } = toRefs(props)as User;

const selectOptionsTyp = ["DE", "AU", "CH"];
const model: User = ref({
        "id": 0,
        "name": "",
        "surname": "",
        "role": "",
        "email": "",
        "land": "DE",
        "plz": null,
        "ortschaft": "",
        "str": "",
        "nr": null,
        "vorwahl": "+43",
        "tel": null,
});

watch(user, changeUser => {
    updatemodel(changeUser);
});

function updatemodel(u: User){
        model.value= u;
}


</script>


<template>
    
        <q-input v-model="model.surname" rounded outlined label="Nachname" class="col-3 "></q-input>
        <q-input v-model="model.name" rounded outlined label="Vorname" class="col-3"></q-input>
        <q-space class="col-3" />
        <q-input v-model="model.email" rounded outlined label="E-Mail" class="col-3" type="email"></q-input>
        <q-space class="col-8" />
        <q-select rounded outlined label="Land" v-model="model.land" :options="selectOptionsTyp" class="col-2"> </q-select>
        <q-input v-model="model.plz" rounded outlined label="PLZ" class="col-2"></q-input>
        <q-input v-model="model.ortschaft" rounded outlined label="Ortschaft" class="col-3"></q-input>
        <q-space class="col-3" />
        <q-input v-model="model.str" rounded outlined label="Strasse" class="col-3"></q-input>
        <q-input v-model="model.nr" rounded outlined label="Nr." class="col-1" type="number"></q-input>
        <q-space class="col-7" />
        <q-select rounded outlined v-model="model.vorwahl" disabled class="col-1"> </q-select>
        <q-input v-model="model.tel" rounded outlined label="Tel-Nummer" class="col-3" type="tel"></q-input>
        
</template>

<style>
.vorwahl{
        text-align: center;
        
}
</style>