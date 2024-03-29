<script lang="ts" setup>
//--------------------- Imports ----------------------------------
import { computed, onMounted, ref, watch } from "vue";
import { toRefs } from "vue";
import { useQuasar } from "quasar";
import type { User } from "@/stores/interfaces";
import { useProjectStore } from "@/stores/projects";
import { useUserStore } from "@/stores/users";

//--------------------- Props / Emit -----------------------------
const props = defineProps<{
    user?: User;
    view?: string;
}>();
const emit = defineEmits<{
    (event: "change:declarations", u: User): void;
}>();

//--------------------- Storeload --------------------------------
const $q = useQuasar();
const projectStore = useProjectStore();
const userStore = useUserStore();

//--------------------- toRefs to props---------------------------
const { user } = toRefs(props) as User;
const { view } = toRefs(props);

//--------------------- variable's -------------------------------
const nameRef = ref(null);
const plzRef = ref(null);
const ortschaftRef = ref(null);
const strasseRef = ref(null);
const strNrRef = ref(null);
const landRef = ref(null);
const surnameRef = ref(null);
const emailRef = ref(null);
const dialog = ref(false);
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
const selectOptionsTyp = ["DE", "AU", "CH", "Sonstiges"];

//--------------------- computed ---------------------------------
const users = computed(() => userStore.users);
const setUser = computed(() => userStore.user);

//--------------------- function's -------------------------------
//--------------- function's for save ----------------------------
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
                await userStore.getUsers();
                model.value = await getUserByEmail(model.value.email);
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
function updateModel(u: User) {
    if (u) {
        model.value = u;
    }
}
function changeValue(p: User) {
    emit("change:declarations", p);
}
//--------------- function's for remove --------------------------
async function remove() {
    // if (model.value.id !== 0) {
    const answer = await userStore.remove(model.value.id);
    if (answer["answer"] == true) {
        $q.notify({
            type: "positive",
            message: "User & Projekt wurde gelöscht",
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

//------------------- function's for validate --------------------
function myvalidate() {
    const nameCheck = nameRef.value.validate();
    const surnameCheck = surnameRef.value.validate();
    const emailCheck = emailRef.value.validate();
    const landCheck = landRef.value.validate();
    const plzCheck = plzRef.value.validate();
    const ortschaftCheck = ortschaftRef.value.validate();
    const strasseCheck = strasseRef.value.validate();
    const strNrCheck = strNrRef.value.validate();
    return !!(
        nameCheck &&
        surnameCheck &&
        emailCheck &&
        landCheck &&
        plzCheck &&
        ortschaftCheck &&
        strasseCheck &&
        strNrCheck
    );
}
// "Exportiert" die Funktion myvalidate() um sie in anderen Komponenten verwenden zu können
defineExpose({ myvalidate });
function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9äöüÄÖÜ@._%+-]{6,254}$)[a-zA-Z0-9äöüÄÖÜ._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalide E-mail";
}
function isValidName(val: string) {
    const namepattern = /^[a-zA-Z äöüÄÖÜ]{2,50}$/;
    return namepattern.test(val) || "Invalider Name";
}
function isValidOrt(val: string) {
    const ortpattern = /^[a-zA-Z äöüÄÖÜ]{2,50}$/;
    return ortpattern.test(val) || "Invalider Ort";
}
function isValidStrasse(val: string) {
    const strassepattern = /^[a-zA-Z äöüÄÖÜ]{2,50}$/;
    return strassepattern.test(val) || "Invalide Strasse";
}
function isValidPlz(val: number) {
    if (model.value.land == "DE") {
        const plzpattern = /^[0-9]{5}$/;
        return plzpattern.test(val) || "Invalide PLZ";
    } else if (model.value.land == "CH" || model.value.land == "AU") {
        const plzpattern = /^[0-9]{4}$/;
        return plzpattern.test(val) || "Invalide PLZ";
    } else {
        const plzpattern = /^[0-9]{4,7}$/;
        return plzpattern.test(val) || "Invalide PLZ";
    }
}

//------------------- function's for load ------------------------
function getUserByEmail(email: string): User {
    return users.value.find(u => u.email === email);
}

//------------------- function's for watch -----------------------
watch(user, changeUser => {
    updateModel(changeUser);
});
onMounted(() => {
    updateModel(user.value);
});
watch(setUser, changeUser => {
    updateModel(changeUser);
});
</script>

<template>
    <div v-if="model">
        <div v-if="model.role !== 'jury'" class="row q-gutter-sm">
            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.surname"
                    ref="surnameRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Nachname *"
                    outlined
                    class="col-4"
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
                    class="col-4"
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
                    ref="emailRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="E-Mail *"
                    outlined
                    disable
                    class="col-5"
                    type="email"
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidEmail]"
                />
            </div>
            <div class="row q-gutter-sm col-12">
                <q-select
                    v-model="model.land"
                    ref="landRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Land *"
                    outlined
                    popup-content-style="bg-secondary"
                    class="col-2"
                    @change="changeValue(model)"
                    :options="selectOptionsTyp"
                    :rules="[val => !!val || 'Pflichtfeld *']"
                />
                <q-input
                    v-model="model.plz"
                    ref="plzRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="PLZ *"
                    outlined
                    class="col-3"
                    type="number"
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidPlz]"
                />
                <q-input
                    v-model="model.ortschaft"
                    ref="ortschaftRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Ortschaft *"
                    outlined
                    class="col-4"
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidOrt]"
                />
            </div>

            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.strasse"
                    ref="strasseRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Strasse *"
                    outlined
                    class="col-5"
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidStrasse]"
                />
                <q-input
                    v-model="model.strNr"
                    ref="strNrRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Nr. *"
                    outlined
                    class="col-2"
                    type="text"
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *']"
                    maxlength="11"
                />
            </div>
            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.vorwahl"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Vorwahl"
                    outlined
                    class="col-2"
                    @change="changeValue(model)"
                />
                <q-input
                    v-model="model.tel"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Tel-Nummer"
                    outlined
                    class="col-3"
                    type="tel"
                    @change="changeValue(model)"
                    maxlength="30"
                />
            </div>
        </div>
        <div v-else class="row q-gutter-sm">
            <div class="row q-gutter-sm col-12">
                <q-input
                    v-model="model.surname"
                    ref="surnameRef"
                    standout="bg-secondary"
                    label-color="accent"
                    label="Nachname *"
                    outlined
                    class="col-4"
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
                    class="col-4"
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
                    class="col-5"
                    type="email"
                    lazy-rules
                    @change="changeValue(model)"
                    :rules="[val => !!val || 'Pflichtfeld *', isValidEmail]"
                />
            </div>
        </div>

        <div v-if="view === 'Project'">
            <div class="q-mb-xl">
                <q-btn label="Änderungen Speichern" color="accent" @click="saveChange" class="genBtn" />
                <q-btn label="Passwort zurücksetzen" color="red-5" @click="resetPw" class="genBtn" />
                <q-btn label="User & Projekt Löschen" color="red-5" @click="dialog = true" class="genBtn" />
            </div>

            <div>
                <q-dialog v-model="dialog" persistent transition-show="scale" transition-hide="scale">
                    <q-card class="bg-grey-3 text-black" style="width: 300px">
                        <q-card-section class="bg-red-5">
                            <div class="text-h6">Löschen?!?</div>
                        </q-card-section>

                        <q-card-section class="q-pt-none bg-secondary">
                            Möchten Sie wirklich den User & das Projekt vollständig Löschen?
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
