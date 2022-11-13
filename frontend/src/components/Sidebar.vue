<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
import { useUserStore } from "@/stores/users";
import { storeToRefs } from "pinia";
import { toRefs, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import type { User, Project } from "@/stores/interfaces";

const props = defineProps<{
    view?: string;
}>();
const { view } = toRefs(props);
//---------------Storeload------------------------------
const authStore = useAuthStore();
const userStore = useUserStore();

//---------------Routload------------------------------
const router = useRouter();
const route = useRoute();
//---------------storeToRefs------------------------------
const { isAuthenticated } = storeToRefs(authStore);
const { users } = storeToRefs(userStore);

const emit = defineEmits<{
    (event: "change:selection", value: User): void;
}>();
//---------------Functions------------------------------
const test = ["DE", "AU", "CH"];
const personen = ref(users.value);
const project: Project[] = [
    {
        id: 1,
        userID: 1,
        userBildID: [1, 2],
    },
    {
        id: 2,
        userID: 2,
        userBildID: [3, 4],
    },
];

function changeSelection(p: User) {
    emit("change:selection", p);
}

function addJury() {
    const u: User = {
        id: 0,
        name: "",
        surname: "",
        role: "jury",
        email: "",
        land: "",
        plz: null,
        ortschaft: "",
        str: "",
        strNr: null,
        vorwahl: "",
        tel: null,
    };
    personen.value.push(u);
    emit("change:selection", u);
}

async function loadUsers() {
    userStore.getUsers();
}

function load() {
    if (view?.value == "User") {
        loadUsers();
    }
}
load();

//---------------Executions------------------------------
</script>
<template>
    <q-drawer show-if-above :width="300" :breakpoint="700" elevated bordered>
        <q-scroll-area class="fit">
            <!-- Hier wird überprüft ob das Obere Element 'User' in das view-Element gepackt hat-->
            <q-card v-if="view === 'User'" bordered>
                <q-card-section color="q-primary" class="fullwitdh">
                    <h4 class="title">Jury</h4>
                </q-card-section>
                <!-- Ein For-loop um jede Person im Array durchzugehen-->
                <div v-for="p in personen" :key="p.id">
                    <!-- Hier wird überprüft ob das ob das Element bei der Rolle 'jury' hinterlegt ist'-->
                    <div v-if="p.role === 'jury'" class="fullwidth">
                        <q-btn class="fullwitdh" bordered color="secondary" @click="changeSelection(p)">{{
                            p.surname + " " + p.name
                        }}</q-btn>
                    </div>
                </div>
                <!-- Button um ein Jurymitglied hinzufügen (noch nicht gespeichert)-->
                <q-btn class="fullwitdh btn" color="primary" @click="addJury">Jurymitglied hinzufügen</q-btn>
                <h4 class="title">Teilnehmende</h4>
                <!-- Ein For-loop um jede Person im Array durchzugehen-->
                <div v-for="p in personen" :key="p.id" class="fullwidth">
                    <!-- Hier wird überprüft ob das ob das Element bei der Rolle 'teilnehmende' hinterlegt ist'-->
                    <div v-if="p.role === 'teilnehmende'">
                        <q-btn class="fullwitdh" color="secondary" @click="changeSelection(p)">{{
                            p.surname + " " + p.name
                        }}</q-btn>
                    </div>
                </div>
            </q-card>
            <!-- Hier wird überprüft ob das Obere Element 'Project' in das view-Element gepackt hat-->
            <q-card v-if="view === 'Project'" bordered>
                <q-card-section color="q-primary" class="fullwitdh">
                    <h4 class="title">Project</h4>
                </q-card-section>
                <!-- Ein For-loop um jedes Projekt im Array durchzugehen-->
                <div v-for="pro in project" :key="pro.id">
                    <div class="fullwidth">
                        <q-btn class="fullwitdh" bordered color="secondary">{{ pro.id }}</q-btn>
                    </div>
                </div>
            </q-card>
        </q-scroll-area>
    </q-drawer>
</template>
<style>
.fullwitdh {
    width: 100%;
    padding: 0%;
}
.title {
    background-color: cornflowerblue;
    text-align: center;
    border-top: solid;
    border-color: blue;
    color: black;
    margin-top: -1px;
}
.btn {
    margin-bottom: 10px;
    margin-top: 5px;
}
</style>
