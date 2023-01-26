<script setup lang="ts">
import { useRouter } from "vue-router";
import { computed, onBeforeMount } from "vue";
import { useQuasar } from "quasar";
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";
import { useUserStore } from "@/stores/users";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();
const $q = useQuasar();
const userStore = useUserStore();

userStore.getUser();

const selectedUser = computed(() => userStore.user);

async function check() {
    const answer: boolean = await authStore.check();
    if (answer == false) {
        router.push("/login");
    } else if (authStore.role == "jury") {
        router.push("/evaluation");
    }
}

onBeforeMount(() => {
    check();
});
</script>
<template>
    <main class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Project :user="selectedUser" />
        </div>
        <div class="q-gutter-lg col-5">
            <Formular :user="selectedUser" />
        </div>
    </main>
</template>
<style></style>
