<script setup lang="ts">
//--------------------- import ----------------------------------
import Loading from "vue-loading-overlay";
import { computed, onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import Formular from "@/components/Formular.vue";
import { useUserStore } from "@/stores/users";
import { useAuthStore } from "@/stores/auth";
import { useCompetitionStore } from "@/stores/competition";

//--------------------- Storeload --------------------------------
const authStore = useAuthStore();
const userStore = useUserStore();
const competitionStore = useCompetitionStore();

//--------------------- variable's -------------------------------
const $q = useQuasar();
const router = useRouter();
let isLoading = ref(false);
const fullPage = ref(true);
const formularRef = ref(null); //ref to child component

//--------------------- computed ---------------------------------
const selectedUser = computed(() => userStore.user);
const competitionDetails = computed(() => competitionStore.competitionDetails);

//----------------- function's for check -------------------------
async function check() {
    const answer: boolean = await authStore.check();
    if (!answer) {
        await router.push("/login");
    } else if (authStore.role == "jury") {
        await router.push("/evaluation");
    } else if (authStore.role == "admin") {
        await router.push("/");
    }
}

//check if competition is open
function dateCheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    return (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    );
}
//----------------- function's from child ------------------------
async function callChildFunction() {
    if (formularRef.value.myvalidate()) {
        isLoading.value = true;
        const answer: number = await userStore.saveUserChange();
        if (answer === 1) {
            $q.notify({
                type: "positive",
                message: "Änderung wurden gespeichert!",
                color: "green",
            });
        } else if (answer === 0) {
            $q.notify({
                type: "negative",
                message: "Der Speichervorgang ist gescheitert",
                color: "red",
            });
        }
    } else {
        $q.notify({
            type: "negative",
            message: "Bitte füllen Sie alle Pflichtfelder aus",
            color: "red",
        });
    }
    isLoading.value = false;
}
//----------------- function's for Mount -------------------------
onBeforeMount(async () => {
    await check();
    await userStore.getUser();
    await competitionStore.getCompetitionDeclarations();
});
</script>
<template>
    <loading
        v-model="isLoading"
        backgroundColor="rgba(0, 0, 0, 0.223)"
        :can-cancel="true"
        :is-full-page="fullPage"
    ></loading>
    <div v-if="dateCheck()">
        <div class="q-ma-md col user-E">
            <Formular :user="selectedUser" ref="formularRef" :view="'User'" />
            <div class="row">
                <q-space />
                <q-btn
                    class="genBtn"
                    color="blue"
                    :loading="isLoading"
                    label="Änderungen Speichern"
                    icon="upload"
                    @click="callChildFunction"
                />
            </div>
        </div>
    </div>
    <div v-else>
        <q-card flat align="center">
            <q-card-section v-html="competitionDetails.wettbewerbCloseText" />
        </q-card>
    </div>
</template>
<style scoped>
.user-E {
    min-width: 500px;
}
</style>
