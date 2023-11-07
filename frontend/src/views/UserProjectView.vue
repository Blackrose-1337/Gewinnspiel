<script setup lang="ts">
//--------------------- import ----------------------------------
import ProjectItem from "@/components/Project.vue";
import Sidebar from "@/components/SidebarUser.vue";
import type { Project } from "@/stores/interfaces";
import { useRouter } from "vue-router";
import { computed, onBeforeMount, Ref, ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useCompetitionStore } from "@/stores/competition";
import Loading from "vue-loading-overlay";

//--------------------- Storeload --------------------------------
const authStore = useAuthStore();
const competitionStore = useCompetitionStore();

//--------------------- variable's -------------------------------
const router = useRouter();
let isLoading = ref(false);
const fullPage = ref(true);

//--------------------- computed ---------------------------------
const competitionDetails = computed(() => competitionStore.competitionDetails);

//--------------------- storeToRefs ------------------------------
const selectedProject = ref(null as unknown) as Ref<Project>;

//--------------------- function's -------------------------------
async function projectChange(p: Project) {
    selectedProject.value = p;
}
//----------------- function's for check -------------------------
//check if user is logged in
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

//----------------- function's before Mount -------------------------
onBeforeMount(async () => {
    await check();
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
    <div v-if="dateCheck()" class="row">
        <Sidebar @change:selectproject="projectChange" />
        <div class="q-ma-md col user-E">
            <ProjectItem :selectedproject="selectedProject" :view="'User'" />
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
