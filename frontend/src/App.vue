<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import { RouterView } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();
const role = computed(() => authStore.role);
const title = ref("Admin");
let menuHover = ref(false);

async function logout() {
    const answer = await authStore.logout();
    if (answer) {
        settitle("Admin");
        await router.push("/login");
    }
}
function settitle(val: string) {
    title.value = val;
}
function menuShow() {
    menuHover.value = true;
}
function menuHide() {
    menuHover.value = false;
}
onMounted(() => {
    const answer = authStore.check();
    if (answer === false) {
        router.push("/login");
    }
});
</script>

<template>
    <q-layout class="bg-primary" view="hHh lpR fFf">
        <q-header elevated class="bg-secondary text-black float-right" height-hint="98">
            <q-toolbar>
                <q-toolbar-title class="row">
                    <img src="@/assets/Stickstoff.png" alt="Logo Stickstoffmagazin" />
                    <q-space />
                </q-toolbar-title>
            </q-toolbar>
            <q-tabs align="left">
                <q-route-tab
                    to="/customer"
                    v-if="role !== 'jury' && role !== 'teilnehmende'"
                    @click="settitle('Admin')"
                    label="Gewinnspiel"
                />
                <q-route-tab to="/user" label="User" v-if="role === 'teilnehmende'" />

                <q-route-tab
                    @click="settitle('Admin')"
                    to="/evaluation"
                    label="Bewertung"
                    v-if="role === 'jury' || role === 'admin'"
                />
                <q-route-tab to="/analysis" label="Auswertung" v-if="role === 'admin'" />
                <q-btn @mouseover="menuShow" flat v-bind:label="title" class="fullheight" v-if="role === 'admin'">
                    <q-menu v-model="menuHover" @mouseleave="menuHide">
                        <q-list style="min-width: 100px">
                            <q-route-tab
                                @click="settitle('Userverwaltung')"
                                to="/verwaltung"
                                label="Userverwaltung"
                                icon="people"
                            />
                            <q-route-tab @click="settitle('Projekte')" to="/project" label="Projekte" icon="description" />
                            <q-route-tab
                                @click="settitle('Konfiguration')"
                                to="/designe"
                                label="Konfiguration"
                                icon="settings"
                            />
                            <q-route-tab
                                @click="settitle('Passwortverwaltung')"
                                to="/password-set"
                                label="Passwortverwaltung"
                                icon="lock"
                            />
                        </q-list>
                    </q-menu>
                </q-btn>
                <q-space />
                <div v-if="role !== 'admin' && role !== 'jury' && role !== 'teilnehmende'">
                    <q-route-tab to="/login" label="Login" />
                </div>
                <div v-else>
                    <q-route-tab @click="logout()" label="Logout" icon="logout" />
                </div>
            </q-tabs>
        </q-header>
        <q-page-container class="bg-primary wrapper">
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<style>
/*noinspection CssUnknownTarget*/
@import "@/assets/base.css";

[for="qfileelements"] .q-chip.row.inline.no-wrap.items-center.q-chip--dense {
    width: 100%;
    height: 40px;
    border-radius: 0;
    margin-right: 10px;
}
.fullheight {
    height: 100%;
}
header {
    line-height: 1.5;
    max-height: 100vh;
    /*background-color: #067213 !important;*/
}
.genBtn {
    border-radius: 5px;
    max-height: 56px;
    min-height: 56px;
    margin-top: 20px;
    margin-left: 24px;
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
