<script setup lang="ts">
import { ref } from "vue";
import { RouterView } from "vue-router";
import { useQuasar } from "quasar";

const $q = useQuasar();
let change = ref();
// darmode toggle
function swap() {
    if (!change.value) {
        change.value = true;
    } else {
        change.value = false;
    }
    $q.dark.set(change.value);
}

console.log("App setup");
</script>

<template>
    <q-layout view="hHh lpR fFf">
        <q-header elevated class="text-white" height-hint="98">
            <q-toolbar>
                <q-toolbar-title>
                    <q-avatar> <img src=src/assets/Blackrose.png alt="Blackrose"/> </q-avatar>
                    Stickstoff
                    <q-btn class="text-right" round @click="swap" push outline icon="light_mode" />
                </q-toolbar-title>
            </q-toolbar>

            <q-tabs align="left">
                <q-route-tab to="/customer" label="Wettbewerb" />
                <q-route-tab to="/user" label="User" />
                <q-btn flat label="Admin" class="fullheight">
                    <q-menu>
                        <q-list style="min-width: 100px">
                            <q-route-tab
                                @click="switcher('setup')"
                                to="/verwaltung"
                                label="Userverwaltung"
                                icon="dynamic_form"
                                on-click="{{}}"
                            />
                            <q-route-tab @click="switcher('setup')" to="/project" label="Projekte" icon="settings" />
                            <!-- läuft noch nicht -->
                            <!-- <q-route-tab
                                @click="switcher('setup')"
                                to="/designe"
                                label="Desgine"
                                icon="settings"
                            /> -->
                        </q-list>
                    </q-menu>
                </q-btn>
                <q-route-tab to="/evaluation" label="Bewertung" />
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
