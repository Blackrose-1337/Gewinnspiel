<script setup lang="ts">
import { useUserStore } from "@/stores/users";
import { useProjectStore } from "@/stores/projects";
import { useEvaluationStore } from "@/stores/evaluation";
import { storeToRefs } from "pinia";
import { toRefs, computed, ref } from "vue";
import type { User, Project } from "@/stores/interfaces";

const props = defineProps<{
    view?: string;
}>();
const { view } = toRefs(props);
//---------------Storeload------------------------------
const userStore = useUserStore();
const projectStore = useProjectStore();
const evaluationStore = useEvaluationStore();

//---------------storeToRefs------------------------------
const { users } = storeToRefs(userStore);
const { projects } = storeToRefs(projectStore);
let styleId = ref(1);
const selected = computed(() => styleId.value);

const emit = defineEmits<{
    (event: "change:selection", value: User): void;
    (event: "change:selectproject", value: Project): void;
}>();
//---------------Functions------------------------------
//const personen = ref(users.value);

function changeSelection(p: User) {
    emit("change:selection", p);
    styleId.value = p.id;
}
function changeSelectProject(pro: Project) {
    emit("change:selectproject", pro);
    styleId.value = pro.id;
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
    users.value.push(u);
    emit("change:selection", u);
}

async function loadUsers() {
    await userStore.getUsers();
}
async function loadProject() {
    await projectStore.getProjects();
}
async function loadProjectEva() {
    await projectStore.getProjectsEva();
}

function load() {
    if (view?.value == "User") {
        loadUsers();
    } else if (view?.value == "Evaluation") {
        loadProjectEva();
    } else {
        loadProject();
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
                    <h4 class="title bg-accent">Jury</h4>
                </q-card-section>
                <!-- Ein For-loop um jede Person im Array durchzugehen-->
                <div v-for="p in users" :key="p.id">
                    <!-- Hier wird überprüft ob das ob das Element bei der Rolle 'jury' hinterlegt ist'-->
                    <div v-if="p.role === 'jury'" class="fullwidth">
                        <q-btn
                            :id="p.id"
                            class="fullwitdh"
                            :style="[selected === p.id ? { background: '#09deed' } : { background: '#D9D9D9FF' }]"
                            bordered
                            @click="changeSelection(p)"
                            >{{ p.surname + " " + p.name }}</q-btn
                        >
                    </div>
                </div>
                <!-- Button um ein Jurymitglied hinzufügen (noch nicht gespeichert)-->
                <q-btn class="fullwitdh btn" color="accent" @click="addJury">Jurymitglied hinzufügen</q-btn>
                <h4 class="title bg-accent">Teilnehmende</h4>
                <!-- Ein For-loop um jede Person im Array durchzugehen-->
                <div v-for="p in users" :key="p.id" class="fullwidth">
                    <!-- Hier wird überprüft ob das ob das Element bei der Rolle 'teilnehmende' hinterlegt ist'-->
                    <div v-if="p.role === 'teilnehmende'">
                        <q-btn
                            class="fullwitdh"
                            :style="[selected === p.id ? { background: '#09deed' } : { background: '#D9D9D9FF' }]"
                            @click="changeSelection(p)"
                            >{{ p.surname + " " + p.name }}</q-btn
                        >
                    </div>
                </div>
            </q-card>

            <!-- Hier wird überprüft ob das Obere Element 'Project' in das view-Element gepackt hat-->
            <q-card v-if="view === 'Project'" bordered>
                <q-card-section color="q-primary" class="fullwitdh">
                    <h4 class="title bg-accent">Project</h4>
                </q-card-section>
                <!-- Ein For-loop um jedes Projekt im Array durchzugehen-->
                <div v-for="pro in projects" :key="pro.id">
                    <div v-if="pro.finish === 1" class="fullwidth">
                        <q-btn
                            class="fullwitdh"
                            bordered
                            :style="[selected === pro.id ? { background: '#09deed' } : { background: '#37ed09' }]"
                            @click="changeSelectProject(pro)"
                            >{{ pro.id }}</q-btn
                        >
                    </div>
                    <div v-else class="fullwidth">
                        <q-btn
                            class="fullwitdh"
                            bordered
                            :style="[selected === pro.id ? { background: '#09deed' } : { background: '#D9D9D9FF' }]"
                            @click="changeSelectProject(pro)"
                            >{{ pro.id }}</q-btn
                        >
                    </div>
                </div>
            </q-card>
            <q-card v-if="view === 'Evaluation'" bordered>
                <q-card-section color="q-primary" class="fullwitdh">
                    <h4 class="title bg-accent">Project</h4>
                </q-card-section>
                <!-- Ein For-loop um jedes Projekt im Array durchzugehen-->
                <div v-for="pro in projects" :key="pro.id">
                    <div v-if="pro.finish === 1" class="fullwidth">
                        <q-btn
                            class="fullwitdh"
                            bordered
                            :style="[selected === pro.id ? { background: '#53b6b2' } : { background: '#37ed09' }]"
                            @click="changeSelectProject(pro)"
                            >{{ pro.id }}</q-btn
                        >
                    </div>
                    <div v-else class="fullwidth">
                        <q-btn
                            class="fullwitdh"
                            bordered
                            :style="[selected === pro.id ? { background: '#53b6b2' } : { background: '#D9D9D9FF' }]"
                            @click="changeSelectProject(pro)"
                            >{{ pro.id }}</q-btn
                        >
                    </div>
                </div>
            </q-card>
        </q-scroll-area>
    </q-drawer>
</template>
<style>
.fullwitdh {
    width: 100%;
    padding: 0;
}
.title {
    background-color: cornflowerblue;
    text-align: center;
    color: black;
    margin-top: -1px;
}
.btn {
    margin-bottom: 10px;
    margin-top: 5px;
}
</style>
