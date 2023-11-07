<script setup lang="ts">
import { useUserStore } from "@/stores/users";
import { useProjectStore } from "@/stores/projects";
import { storeToRefs } from "pinia";
import { computed, onBeforeMount, ref, toRefs } from "vue";
import type { Project, User } from "@/stores/interfaces";
import { sortBy } from "lodash";
import SidebarProject from "@/components/SidebarProject.vue";

const props = defineProps<{
    view?: string;
}>();
const { view } = toRefs(props);
//---------------Storeload------------------------------
const userStore = useUserStore();
const projectStore = useProjectStore();

//---------------storeToRefs------------------------------
const { users } = storeToRefs(userStore);
const { projects } = storeToRefs(projectStore);
let styleId = ref(1);

const projectsSorted = computed(() => sortBy(projects.value, project => getUser(project.userId).toLowerCase()));
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
function getUser(id: number) {
    const user = users.value.find(u => u.id == id) || {};
    return user.surname + " " + user.name;
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
        strasse: "",
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

async function load() {
    if (view?.value == "User") {
        await loadUsers();
    } else if (view?.value == "Evaluation") {
        await loadProjectEva();
    } else {
        await loadUsers();
        await loadProject();
    }
}

onBeforeMount(async () => {
    await load();
});

//---------------Executions------------------------------
</script>
<template>
    <q-drawer show-if-above :breakpoint="700" elevated bordered>
        <q-scroll-area class="fit">
            <!-- Hier wird überprüft ob das Obere Element 'User' in das view-Element gepackt hat-->
            <q-card v-if="view === 'User'" bordered>
                <q-card-section color="q-primary" class="full-width q-pa-none">
                    <h4 class="title bg-accent">Jury</h4>
                </q-card-section>
                <!-- Ein For-loop um jede Person im Array durchzugehen-->
                <div v-for="p in users" :key="p.id">
                    <!-- Hier wird überprüft ob das ob das Element bei der Rolle 'jury' hinterlegt ist'-->
                    <div v-if="p.role === 'jury'" class="full-width q-pa-none">
                        <q-btn
                            :id="p.id"
                            class="full-width q-pa-none"
                            :style="{ background: styleId === p.id ? '#09deed' : '#D9D9D9FF' }"
                            bordered
                            @click="changeSelection(p)"
                            >{{ p.surname + " " + p.name }}</q-btn
                        >
                    </div>
                </div>
                <!-- Button um ein Jurymitglied hinzufügen (noch nicht gespeichert)-->
                <q-btn class="full-width q-pa-none btn" color="accent" @click="addJury">Jurymitglied hinzufügen</q-btn>
                <h4 class="title bg-accent">Teilnehmende</h4>
                <!-- Ein For-loop um jede Person im Array durchzugehen-->
                <div v-for="p in users" :key="p.id" class="full-width q-pa-none">
                    <!-- Hier wird überprüft ob das ob das Element bei der Rolle 'teilnehmende' hinterlegt ist'-->
                    <div v-if="p.role === 'teilnehmende'">
                        <q-btn
                            class="full-width q-pa-none"
                            :style="{ background: styleId === p.id ? '#09deed' : '#D9D9D9FF' }"
                            @click="changeSelection(p)"
                            >{{ p.surname + " " + p.name }}</q-btn
                        >
                    </div>
                </div>
            </q-card>

            <!-- Hier wird überprüft ob das Obere Element 'Project' in das view-Element gepackt hat-->
            <q-card v-if="view === 'Project'" bordered>
                <q-card-section color="q-primary" class="full-width q-pa-none">
                    <h4 class="title bg-accent">Project</h4>
                </q-card-section>
                <!-- Ein For-loop um jedes Projekt im Array durchzugehen-->
                <SidebarProject
                    v-for="project in projectsSorted"
                    :key="project.id"
                    :project="project"
                    :selected="styleId === project.id"
                    @select="() => changeSelectProject(project)"
                />
            </q-card>
            <q-card v-if="view === 'Evaluation'" bordered>
                <q-card-section color="q-primary" class="full-width q-pa-none">
                    <h4 class="title bg-accent">Project</h4>
                </q-card-section>
                <!-- Ein For-loop um jedes Projekt im Array durchzugehen-->
                <div v-for="pro in projects" :key="pro.id">
                    <div v-if="pro.finish === 1" class="full-width q-pa-none">
                        <q-btn
                            class="full-width q-pa-none"
                            bordered
                            :style="{ background: styleId === pro.id ? '#53b6b2' : '#37ed09' }"
                            @click="changeSelectProject(pro)"
                            >{{ pro.id }}</q-btn
                        >
                    </div>
                    <div v-else class="full-width q-pa-none">
                        <q-btn
                            class="full-width q-pa-none"
                            bordered
                            :style="{ background: styleId === pro.id ? '#53b6b2' : '#D9D9D9FF' }"
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
