<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { toRefs } from "vue";
import { useRoute, useRouter } from "vue-router";
import type { User, Project } from "@/stores/interfaces";

const props = defineProps<{
    view?: string;
}>();
const { view } = toRefs(props);
//---------------Storeload------------------------------
const authStore = useAuthStore();

//---------------Routload------------------------------
const router = useRouter();
const route = useRoute();
//---------------storeToRefs------------------------------
const { isAuthenticated } = storeToRefs(authStore);

const emit = defineEmits<{
    (event: "change:selection", value: User): void;
}>();
//---------------Functions------------------------------
const test = ["DE", "AU", "CH"];
const personen: User[] = [
    {
        id: 1,
        name: "Peter",
        surname: "Müller",
        role: "Teilnehmende",
        mail: "peter.müller@gmail.com",
    },
    {
        id: 2,
        name: "Stephan",
        surname: "Hoese",
        role: "Jury",
        mail: "stehan.hoese@gmail.com",
    },
    {
        id: 3,
        name: "Claudia",
        surname: "Stimmer",
        role: "Teilnehmende",
        mail: "claudia.stimmer@gmail.com",
    },
];
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

function addUser() {
    console.log("noch in arbeit");
}

//---------------Executions------------------------------
</script>
<template>
    <!-----------------Sidebar-------------------------------->
    <!-- <q-drawer position="left-top" show-if-above side="left"  width="200" bordered>
        <q-expansion-item icon="drafts" label="Drafts" header-class="text-orange">
            <q-card>
                <q-card-section>
                    <router-link to="/"> Link <q-btn /> </router-link>
                </q-card-section>
            </q-card>
        </q-expansion-item>
        
    </q-drawer> -->

    <q-drawer show-if-above :width="300" :breakpoint="700" elevated bordered>
        <q-scroll-area class="fit">
            <q-card v-if="view === 'User'" bordered>
                <q-card-section color="q-primary" class="fullwitdh">
                    <h4 class="title">Jury</h4>
                </q-card-section>
                <div v-for="p in personen" :key="p.id">
                    <div v-if="p.role === 'Jury'" class="fullwidth">
                        <q-btn class="fullwitdh" bordered color="secondary" @click="changeSelection(p)">{{
                            p.surname + " " + p.name
                        }}</q-btn>
                    </div>
                </div>
                <q-btn class="fullwitdh btn" color="primary" @click="addUser">Jurymitglied hinzufügen</q-btn>

                <h4 class="title">Teilnehmende</h4>
                <div v-for="p in personen" :key="p.id" class="fullwidth">
                    <div v-if="p.role === 'Teilnehmende'">
                        <q-btn class="fullwitdh" color="secondary" @click="changeSelection(p)">{{
                            p.surname + " " + p.name
                        }}</q-btn>
                    </div>
                </div>
            </q-card>
            <q-card v-if="view === 'Project'" bordered>
                <q-card-section color="q-primary" class="fullwitdh">
                    <h4 class="title">Project</h4>
                </q-card-section>
                <div v-for="pro in project" :key="pro.id">
                    <div class="fullwidth">
                        <q-btn class="fullwitdh" bordered color="secondary">{{ pro.id }}</q-btn>
                    </div>
                </div>
            </q-card>
        </q-scroll-area>
    </q-drawer>
    <!-----------------Main-------------------------------->
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
