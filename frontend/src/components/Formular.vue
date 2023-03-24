<script lang="ts" setup>
import { ref, watch } from "vue";
import { toRefs } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import type { User } from "@/stores/interfaces";
import { useProjectStore } from "@/stores/projects";
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
    strasse: "",
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
const { view } = toRefs(props);

const projectStore = useProjectStore();
const userStore = useUserStore();
const nameRef = ref(null);
const surnameRef = ref(null);
const emailRef = ref(null);

const selectOptionsTyp = ["DE", "AU", "CH"];

function myvalidate() {
    nameRef.value.validate();
    surnameRef.value.validate();
    emailRef.value.validate();
}
defineExpose({ myvalidate });
function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}
function isValidName(val: string) {
    const namepattern = /[a-zA-Z]{2,50}$/;
    return namepattern.test(val) || "Invalid name";
}
function changeValue(p: User) {
    emit("change:declarations", p);
}
function updateModel(u: User) {
    model.value = u;
}
async function saveChange() {
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
        let answer1 = true;
        if (view?.value == "User") {
            answer1 = await projectStore.postProject();
        }
        if (answer1) {
            const answer = await userStore.saveUserChange(model.value);
            if (answer == true) {
                $q.notify({
                    type: "positive",
                    message: "Änderungen wurden gespeichert",
                });
            } else {
                $q.notify({
                    type: "negative",
                    message: "Daten konnten nicht gespeichert werden.",
                });
            }
        } else {
            $q.notify({
                type: "negative",
                message: "Daten konnten nicht gespeichert werden.",
            });
        }
    }
}
async function remove() {
    const answer = await userStore.remove(model.value.id);
    if (answer == true) {
        $q.notify({
            type: "positive",
            message: "User wurde gelöscht",
            color: "green",
        });
    } else {
        $q.notify({
            type: answer.success,
            message: answer.error,
        });
    }
}
async function resetPw() {
    const answer = await userStore.resetPW(model.value.id);
    console.log(answer);
    if (answer) {
        $q.notify({
            type: "positive",
            message: "Passwort wurde zurückgesetzt",
            color: "green",
        });
    } else {
        $q.notify({
            type: "negative",
            message: "Das ist was Schiefgelaufen",
        });
    }
}

watch(user, changeUser => {
    updateModel(changeUser);
});
</script>

<template>
    <div>
        <div class="row q-gutter-sm">
            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.surname"
                    ref="surnameRef"
                    rounded
                    outlined
                    label="Nachname *"
                    @change="changeValue(model)"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *', isValidName]"
                    clearable
                    class="col-4"
                />
                <q-input
                    v-model="model.name"
                    ref="nameRef"
                    rounded
                    outlined
                    label="Vorname *"
                    @change="changeValue(model)"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *', isValidName]"
                    clearable
                    class="col-4"
                />
            </div>
            <div v-if="view !== 'User'" class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.email"
                    ref="emailRef"
                    rounded
                    outlined
                    label="E-Mail *"
                    @change="changeValue(model)"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *', isValidEmail]"
                    clearable
                    class="col-5"
                    type="email"
                />
            </div>
            <div v-else class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.email"
                    rounded
                    outlined
                    disable
                    label="E-Mail *"
                    @change="changeValue(model)"
                    lazy-rules
                    :rules="[val => !!val || 'Pflichtfeld *', isValidEmail]"
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
                    @change="changeValue(model)"
                    v-model="model.land"
                    :options="selectOptionsTyp"
                    class="col-2"
                />
                <q-input
                    v-model="model.plz"
                    rounded
                    outlined
                    label="PLZ"
                    @change="changeValue(model)"
                    clearable
                    class="col-3"
                    type="number"
                />
                <q-input
                    v-model="model.ortschaft"
                    rounded
                    outlined
                    label="Ortschaft"
                    @change="changeValue(model)"
                    clearable
                    class="col-4"
                />
            </div>

            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.strasse"
                    rounded
                    outlined
                    label="Strasse"
                    @change="changeValue(model)"
                    clearable
                    class="col-3"
                />
                <q-input
                    v-model="model.strNr"
                    rounded
                    outlined
                    label="Nr."
                    @change="changeValue(model)"
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
                    @change="changeValue(model)"
                    clearable
                    class="col-2"
                />
                <q-input
                    v-model="model.tel"
                    rounded
                    outlined
                    label="Tel-Nummer"
                    @change="changeValue(model)"
                    clearable
                    class="col-3"
                    type="tel"
                />
            </div>
        </div>

        <div v-if="view === 'Project'">
            <q-btn label="Änderungen Speichern" color="blue" @click="saveChange" class="genBtn" />
            <q-btn label="Passwort zurücksetzen" color="red" @click="resetPw" class="genBtn" />
            <q-btn label="User Löschen" color="red" @click="remove" class="genBtn" />
        </div>
    </div>
</template>

<style>
.genBtn {
    border-radius: 30px;
    max-height: 56px;
    min-height: 56px;
    margin-top: 20px;
    margin-left: 24px;
}
</style>
