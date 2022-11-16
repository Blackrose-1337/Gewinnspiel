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
    land: "",
    plz: null,
    ortschaft: "",
    str: "",
    strNr: null,
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
async function savechange() {
    if (model.value.surname == "") {
        $q.notify({
            type: "negative",
            message: "Der Nachname fehlt",
            color: "red",
        });
    } else if (model.value.name == "") {
        $q.notify({
            type: "negative",
            message: "Der Vorname fehlt",
            color: "red",
        });
    } else if (model.value.email == "") {
        $q.notify({
            type: "negative",
            message: "Die E-Mail fehlt",
            color: "red",
        });
    } else {
        userStore.saveUserChange(model.value);
    }
}
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
</script>

<template>
    <div>
        <div class="row q-gutter-sm">
            <div class="row q-gutter-sm col-12">
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
            </div>
            <div class="row q-gutter-sm col-12">
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
            </div>
            <div class="row q-gutter-sm col-12">
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
            </div>

            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.strasse"
                    rounded
                    outlined
                    label="Strasse"
                    @change="changevalue(model)"
                    clearable
                    class="col-3"
                />
                <q-input
                    v-model="model.strNr"
                    rounded
                    outlined
                    label="Nr."
                    @change="changevalue(model)"
                    class="col-2"
                    type="number"
                />
            </div>
            <div class="row q-gutter-sm col-12">
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
        </div>
        <div v-if="view == 'User'">
            <q-btn label="Passwort zurücksetzen" color="red" @click="resestpw" class="rebtn" />
            <q-btn label="Änderungen Speichern" color="blue" @click="savechange" class="rebtn" />
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
    margin-left: 24px;
}
</style>
