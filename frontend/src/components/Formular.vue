<script setup lang="ts">
import { ref, watch } from "vue";
import { toRefs } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import type { User } from "@/stores/interfaces";
import { useUserStore } from "@/stores/users";

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

const props = defineProps<{
    user?: User;
    view?: string;
}>();

const emit = defineEmits<{
    (event: "change:declarations", u: User): void;
}>();

const $q = useQuasar();
const { user } = toRefs(props) as User;

const userStore = useUserStore();

const selectOptionsTyp = ["DE", "AU", "CH"];

function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}
function isValidname(val: string) {
    const namepattern = /[a-zA-Z]{2,50}$/;
    return namepattern.test(val) || "Invalid name";
}
function changevalue(p: User) {
    emit("change:declarations", p);
}
function updatemodel(u: User) {
    model.value = u;
}
function load() {}
async function resestpw() {
    const answer = await userStore.resetPW(model.value.id);
    if (answer == true) {
        $q.notify({
            type: "positive",
            message: "Passwort wurde zurückgesetzt",
            color: "green",
        });
    }
}

watch(user, changeUser => {
    updatemodel(changeUser);
});
load();
</script>

<template>
    <div>
        <div class="row q-gutter-lg">
            <q-input
                v-model="model.surname"
                rounded
                outlined
                label="Nachname"
                @change="changevalue(model)"
                lazy-rules
                :rules="[val => !!val || 'Field is required', isValidname]"
                clearable
                class="col-4"
            />
            <q-input
                v-model="model.name"
                rounded
                outlined
                label="Vorname"
                @change="changevalue(model)"
                lazy-rules
                :rules="[val => !!val || 'Field is required', isValidname]"
                clearable
                class="col-4"
            />
            <q-space class="col-1" />
            <q-input
                v-model="model.email"
                rounded
                outlined
                label="E-Mail"
                @change="changevalue(model)"
                lazy-rules
                :rules="[val => !!val || 'Field is required', isValidEmail]"
                clearable
                class="col-5"
                type="email"
            />
            <q-space class="col-6" />
            <q-select
                rounded
                outlined
                label="Land"
                @change="changevalue(model)"
                v-model="model.land"
                :options="selectOptionsTyp"
                class="col-2"
            />
            <q-input
                v-model="model.plz"
                rounded
                outlined
                label="PLZ"
                @change="changevalue(model)"
                clearable
                class="col-2"
            />
            <q-input
                v-model="model.ortschaft"
                rounded
                outlined
                label="Ortschaft"
                @change="changevalue(model)"
                clearable
                class="col-3"
            />
            <q-space class="col-3" />
            <q-input
                v-model="model.str"
                rounded
                outlined
                label="Strasse"
                @change="changevalue(model)"
                clearable
                class="col-3"
            />
            <q-input
                v-model="model.nr"
                rounded
                outlined
                label="Nr."
                @change="changevalue(model)"
                class="col-2"
                type="number"
            />
            <q-space class="col-5" />
            <q-input
                rounded
                outlined
                v-model="model.vorwahl"
                label="Vorwahl"
                @change="changevalue(model)"
                clearable
                class="col-2"
            />
            <q-input
                v-model="model.tel"
                rounded
                outlined
                label="Tel-Nummer"
                @change="changevalue(model)"
                clearable
                class="col-3"
                type="tel"
            />
        </div>
        <div>
            <q-btn v-if="view == 'User'" label="Passwort zurücksetzen" color="red" @click="resestpw" class="rebtn" />
        </div>
    </div>
</template>

<style>
.vorwahl {
    text-align: center;
}
.rebtn {
    border-radius: 30px;
    max-height: 56px;
    min-height: 56px;
    margin-top: 20px;
}
</style>
