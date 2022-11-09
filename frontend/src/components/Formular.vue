<script setup lang="ts">
import { ref, watch } from "vue";
import { toRefs } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import { useUserStore } from "@/stores/users";
import type { User } from "@/stores/interfaces";

const props = defineProps<{
    user?: User;
}>();

const { user } = toRefs(props) as User;
const emit = defineEmits<{
    (event: "change:declarations", user: User): void;
}>();
const selectOptionsTyp = ["DE", "AU", "CH"];
const model: User = ref({
    id: 0,
    name: "",
    surname: "",
    role: "",
    email: "",
    land: "DE",
    plz: null,
    ortschaft: "",
    str: "",
    nr: null,
    vorwahl: "",
    tel: null,
});
if (!user) {
    console.log("user: " + user.value);
    user.value = model.value;
}

watch(user, changeUser => {
    console.log(user);
    updatemodel(changeUser);
});

function updatemodel(u: User) {
    model.value = u;
}
</script>

<template>
    <q-input
        v-model="model.surname"
        rounded
        outlined
        label="Nachname"
        @change="emit('change:declarations', user.surname)"
        clearable
        class="col-3"
    />
    <q-input
        v-model="model.name"
        rounded
        outlined
        label="Vorname"
        @change="emit('change:declarations', user.name)"
        clearable
        class="col-3"
    />
    <q-space class="col-3" />
    <q-input
        v-model="model.email"
        rounded
        outlined
        label="E-Mail"
        @change="emit('change:declarations', user.email)"
        clearable
        class="col-3"
        type="email"
    />
    <q-space class="col-8" />
    <q-select
        rounded
        outlined
        label="Land"
        @change="emit('change:declarations', user.land)"
        v-model="model.land"
        :options="selectOptionsTyp"
        class="col-2"
    />
    <q-input
        v-model="model.plz"
        rounded
        outlined
        label="PLZ"
        @change="emit('change:declarations', user.plz)"
        clearable
        class="col-2"
    />
    <q-input
        v-model="model.ortschaft"
        rounded
        outlined
        label="Ortschaft"
        @change="emit('change:declarations', user.ortschaft)"
        clearable
        class="col-3"
    />
    <q-space class="col-3" />
    <q-input
        v-model="model.str"
        rounded
        outlined
        label="Strasse"
        @change="emit('change:declarations', user.str)"
        clearable
        class="col-3"
    />
    <q-input
        v-model="model.nr"
        rounded
        outlined
        label="Nr."
        @change="emit('change:declarations', user.nr)"
        class="col-2"
        type="number"
    />
    <q-space class="col-5" />
    <q-input
        rounded
        outlined
        v-model="model.vorwahl"
        label="Vorwahl"
        @change="emit('change:declarations', user.vorwahl)"
        clearable
        class="col-2"
    />
    <q-input
        v-model="model.tel"
        rounded
        outlined
        label="Tel-Nummer"
        @change="emit('change:declarations', user.tel)"
        clearable
        class="col-3"
        type="tel"
    />
</template>

<style>
.vorwahl {
    text-align: center;
}
</style>
