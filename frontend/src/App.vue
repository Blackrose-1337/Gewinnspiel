<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import { RouterView } from "vue-router";
import { useQuasar } from "quasar";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();
const role = computed(() => authStore.role);
const $q = useQuasar();
const title = ref("Admin");
let change = ref();
// darkmode toggle
function swap() {
    if (!change.value) {
        change.value = true;
    } else {
        change.value = false;
    }
    $q.dark.set(change.value);
}
async function logout() {
    const answer = await authStore.logout();
    if (answer === true) {
        settitle("Admin");
        await router.push("/login");
    }
}
function settitle(val: string) {
    title.value = val;
}
onMounted(() => {
    const answer = authStore.check();
    if (answer === false) {
        router.push("/login");
    }
});
</script>

<template>
    <q-layout view="hHh lpR fFf">
        <q-header elevated class="text-white float-right" height-hint="98">
            <q-toolbar>
                <q-toolbar-title>
                    <!-- <q-avatar> <img src=src/assets/Blackrose.png alt="Blackrose"/> </q-avatar> -->
                    Stickstoff
                    <q-btn class="text-right" round @click="swap" push outline icon="light_mode" />
                </q-toolbar-title>
            </q-toolbar>
            <q-tabs align="left">
                <q-route-tab to="/customer" @click="settitle('Admin')" label="Wettbewerb" />
                <q-route-tab to="/user" label="User" v-if="role === 'teilnehmende'" />
                <q-btn flat v-bind:label="title" class="fullheight" v-if="role === 'admin'">
                    <q-menu>
                        <q-list style="min-width: 100px">
                            <q-route-tab
                                @click="settitle('Userverwaltung')"
                                to="/verwaltung"
                                label="Userverwaltung"
                                icon="dynamic_form"
                            />
                            <q-route-tab @click="settitle('Projekte')" to="/project" label="Projekte" icon="settings" />

                            <!-- läuft noch nicht -->
                            <q-route-tab @click="settitle('Desgine')" to="/designe" label="Desgine" icon="settings" />
                        </q-list>
                    </q-menu>
                </q-btn>
                <q-route-tab
                    @click="settitle('Admin')"
                    to="/evaluation"
                    label="Bewertung"
                    v-if="role === 'jury' || role === 'admin'"
                />
                <q-space />
                <div v-if="role !== 'admin' && role !== 'jury' && role !== 'teilnehmende'">
                    <q-route-tab to="/login" label="Login" />
                </div>
                <div v-else>
                    <q-route-tab @click="logout()" label="Logout" />
                </div>
            </q-tabs>
        </q-header>
        <q-page-container class="wrapper">
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<style>
/*noinspection CssUnknownTarget*/
@import "@/assets/base.css";

.fullheight {
    height: 100%;
}
.body--dark {
    background-color: #343232;
}

header {
    line-height: 1.5;
    max-height: 100vh;
    background-color: #067213 !important;
}

.logo {
    display: block;
    margin: 0 auto 2rem;
}

a,
.green {
    text-decoration: none;
    color: hsla(160, 100%, 37%, 1);
    transition: 0.4s;
}

@media (hover: hover) {
    a:hover {
        background-color: hsla(160, 100%, 37%, 0.2);
    }
}

nav {
    width: 100%;
    font-size: 12px;
    text-align: center;
    margin-top: 2rem;
}

nav a.router-link-exact-active {
    color: var(--color-text);
}

nav a.router-link-exact-active:hover {
    background-color: transparent;
}

nav a {
    /*display: inline-block;*/
    padding: 0 1rem;
    border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
    border: 0;
}
</style>
