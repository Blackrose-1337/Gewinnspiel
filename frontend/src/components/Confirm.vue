<script setup lang="ts">
import { computed, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useConfirmStore } from "@/stores/confirm";

const confirmStore = useConfirmStore();
const route = useRoute();
const router = useRouter();

function login() {
    router.push("/login");
}

const user = computed(() => confirmStore.user);
onMounted(() => {
    confirmStore.confirm(route.params.poppel);
});
</script>
<template>
    <div v-if="user.id === 0">
        <q-card flat align="center">
            <h4>
                Der Bestätigungstoken ({{ $route.params.poppel }}) existiert nicht. Bitte wenden Sie sich an den
                Administrator der Seite.
            </h4>
        </q-card>
    </div>
    <div v-if="user.id === 1">
        <q-card flat align="center">
            <h4>
                Vielen Dank für ihre Bestätigung {{ user.surname }} {{ user.name }}. Mit ihrer Mail
                {{ user.email }} können Sie sich nun auf der Seite anmelden.
            </h4>
        </q-card>
    </div>
    <div v-if="user.id === 2">
        <q-card flat align="center" class="q-ma-sm">
            <h4>Ihre E-mail {{ user.email }} ist bereits bestätigt. Sie können sich unter</h4>
            <q-btn push size="30px" label="Login" @click="login()"></q-btn>
            <h4>einloggen um ihr Projekt anzusehen.</h4>
        </q-card>
    </div>
</template>
<style scoped></style>
