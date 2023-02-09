<script setup lang="ts">
import { useRouter } from "vue-router";
import { computed, onBeforeMount } from "vue";
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";
import { useUserStore } from "@/stores/users";
import { useAuthStore } from "@/stores/auth";
import { useCompetitionStore } from "@/stores/competition";

const router = useRouter();
const authStore = useAuthStore();
const userStore = useUserStore();
const competitionstore = useCompetitionStore();

competitionstore.getCompetitiondeclarations();

const selectedUser = computed(() => userStore.user);
const competitionDetails = computed(() => competitionstore.competitionDetails);

async function check() {
    const answer: boolean = await authStore.check();
    if (answer == false) {
        router.push("/login");
    } else if (authStore.role == "jury") {
        router.push("/evaluation");
    } else if (authStore.role == "admin") {
        router.push("/");
    }
}
function datecheck() {
    const currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
    if (
        currentDateWithFormat > competitionDetails.value.wettbewerbbeginn &&
        currentDateWithFormat < competitionDetails.value.wettbewerbende
    ) {
        return true;
    } else {
        return false;
    }
}

onBeforeMount(() => {
    check();
    userStore.getUser();
});
</script>
<template>
    <div v-if="datecheck()" class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Project :user="selectedUser" :view="'User'" />
        </div>
        <div class="q-gutter-lg col-5">
            <Formular :user="selectedUser" :view="'User'" />
        </div>
    </div>
    <div v-else>
        <q-card flat align="center">
            <q-card-section v-html="competitionDetails.wettbewerbCloseText" />
        </q-card>
    </div>
</template>
<style scoped>
.own {
    padding: 10px;
    border: solid black;
}
</style>
