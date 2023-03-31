<script lang="ts" setup>
import { ref, watch } from "vue";
import { toRefs } from "vue";
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
const dialog = ref(false);

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
    if (answer["answer"] == true) {
        $q.notify({
            type: "positive",
            message: "User wurde gelöscht",
            color: "green",
        });
    } else {
        $q.notify({
            type: answer["type"],
            message: answer["message"],
        });
    }
    await userStore.getUsers();
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
                    standout="bg-secondary"
                    label-color="accent"
                    label="Nachname *"
                    outlined
                    clearable
                    class="col-4"
                    lazy-rules
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidName]"
                />
                <q-input
                    v-model="model.name"
                    ref="nameRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Vorname *"
                    outlined
                    clearable
                    class="col-4"
                    lazy-rules
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidName]"
                />
            </div>
            <div v-if="view !== 'User'" class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.email"
                    ref="emailRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="E-Mail *"
                    outlined
                    clearable
                    class="col-5"
                    type="email"
                    lazy-rules
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidEmail]"
                />
            </div>
            <div v-else class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.email"
                    standout="bg-secondary"
                    label-color="accent"
                    label="E-Mail *"
                    outlined
                    disable
                    clearable
                    class="col-5"
                    type="email"
                    lazy-rules
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidEmail]"
                />
            </div>
            <div class="row q-gutter-sm col-12">
                <q-select
                    v-model="model.land"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Land"
                    outlined
                    popup-content-style="bg-secondary"
                    class="col-2"
                    @change="changeValue(model)"
                    :options="selectOptionsTyp"
                />
                <q-input
                    v-model="model.plz"
                    standout="bg-secondary"
                    label-color="accent"
                    label="PLZ"
                    outlined
                    clearable
                    class="col-3"
                    type="number"
                    @change="changeValue(model)"
                />
                <q-input
                    v-model="model.ortschaft"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Ortschaft"
                    outlined
                    clearable
                    class="col-4"
                    @change="changeValue(model)"
                />
            </div>

            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.strasse"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Strasse"
                    outlined
                    clearable
                    class="col-5"
                    @change="changeValue(model)"
                />
                <q-input
                    v-model="model.strNr"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Nr."
                    outlined
                    class="col-2"
                    type="number"
                    @change="changeValue(model)"
                />
            </div>
            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.vorwahl"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Vorwahl"
                    outlined
                    clearable
                    class="col-2"
                    @change="changeValue(model)"
                />
                <q-input
                    v-model="model.tel"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Tel-Nummer"
                    outlined
                    clearable
                    class="col-3"
                    type="tel"
                    @change="changeValue(model)"
                />
            </div>
        </div>

        <div v-if="view === 'Project'">
            <q-btn label="Änderungen Speichern" color="accent" @click="saveChange" class="genBtn" />
            <q-btn label="Passwort zurücksetzen" color="red-5" @click="resetPw" class="genBtn" />
            <q-btn label="User Löschen" color="red-5" @click="dialog = true" class="genBtn" />
            <div>
                <q-dialog v-model="dialog" persistent transition-show="scale" transition-hide="scale">
                    <q-card class="bg-grey-3 text-black" style="width: 300px">
                        <q-card-section class="bg-red-5">
                            <div class="text-h6">Löschen?!?</div>
                        </q-card-section>

                        <q-card-section class="q-pt-none bg-secondary">
                            Möchten Sie wirklich den User vollständig Löschen?
                        </q-card-section>

                        <q-card-actions align="right" class="bg-secondary text-teal">
                            <q-btn flat color="black" class="bg-red-6" label="Löschen" @click="remove" v-close-popup />
                            <q-btn flat color="black" class="bg-grey-6" label="Abbrechen" v-close-popup />
                        </q-card-actions>
                    </q-card>
                </q-dialog>
            </div>
        </div>
    </div>
</template>

<style></style>
