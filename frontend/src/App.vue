<script setup lang="ts">
import { ref } from "vue";
import { RouterView } from "vue-router";
import { useQuasar } from "quasar";

const $q = useQuasar();
let change = ref();
function swap() {
    if (!change.value) {
        change.value = true;
    } else {
        change.value = false;
    }
    $q.dark.set(change.value);
}
// $q.dark.set(change.value);

console.log("App setup");
</script>

<template>
    <q-layout view="hHh lpR fFf">
        <q-header elevated class="text-white" height-hint="98">
            <q-toolbar>
                <q-toolbar-title>
                    <!-- <q-avatar> <img src=src/assets/Blackrose.png alt="Blackrose"/> </q-avatar>-->
                    Stickstoff
                    <q-btn class="text-right" round @click="swap" push outline icon="light_mode" />
                </q-toolbar-title>
            </q-toolbar>

            <q-tabs align="left">
                <q-route-tab to="/" label="Home" />
                <q-route-tab to="/customer" label="Wettbewerb" />
                <q-route-tab to="/user" label="User" />
                <q-btn flat label="Admin" class="fullheight">
                    <q-menu >
                    <q-list style="min-width: 100px">
                            <q-route-tab
                                @click="switcher('setup')"
                                to="/verwaltung"
                                label="Userverwaltung"
                                icon="dynamic_form"
                                on-click="{{}}"
                            />
                            <q-route-tab
                                @click="switcher('setup')"
                                to="/project"
                                label="Projekte"
                                icon="settings"
                            />
                            <q-route-tab
                                @click="switcher('setup')"
                                to="/designe"
                                label="Desgine"
                                icon="settings"
                            />
                            
                        </q-list>
                </q-menu>
                </q-btn>
                <q-route-tab to="/evaluation" label="Bewertung" />
            </q-tabs>
        </q-header>
        <!--TEST-->
        <!--        <q-drawer show-if-above v-model="leftDrawerOpen" side="left" behavior="desktop" bordered>-->
        <!--            <RouterLink to="/">Home</RouterLink> <br />-->
        <!--            <RouterLink to="/login">Login</RouterLink> <br />-->
        <!--            <RouterLink to="/about">About</RouterLink> <br />-->
        <!--            foobar-->
        <!--        </q-drawer>-->

        <q-page-container class="wrapper">
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<style>
/*noinspection CssUnknownTarget*/
@import "@/assets/base.css";

/* #app {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem;

    font-weight: normal;
} */
.fullheight{
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

/*@media (min-width: 1024px) {*/
/*    body {*/
/*        display: flex;*/

/*        place-items: flex-start;*/
/*    }*/

/*    #app {*/
/*        !*display: grid;*!*/
/*        !*grid-template-columns: 1fr 1fr;*!*/
/*        padding: 0 2rem;*/
/*    }*/

/*    header {*/
/*        !*display: flex;*!*/
/*        place-items: center;*/
/*        padding-right: calc(var(--section-gap) / 2);*/
/*    }*/

/*    header .wrapper {*/
/*        display: flex;*/
/*        place-items: flex-start;*/
/*        flex-wrap: wrap;*/
/*    }*/

/*    .logo {*/
/*        margin: 0 2rem 0 0;*/
/*    }*/

/*    nav {*/
/*        text-align: left;*/
/*        margin-left: -1rem;*/
/*        font-size: 1rem;*/

/*        padding: 1rem 0;*/
/*        margin-top: 1rem;*/
/*    }*/
/*}*/
</style>
