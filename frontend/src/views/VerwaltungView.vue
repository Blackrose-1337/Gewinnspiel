<script setup lang="ts">
import type { Ref } from "vue";
import { ref, onBeforeMount } from "vue";
import { useAuthStore } from "@/stores/auth";
import Formular from "@/components/Formular.vue";
import Sidebar from "@/components/Sidebar.vue";
import Project from "@/components/Project.vue";
import type { User } from "@/stores/interfaces";
import { useRouter } from "vue-router";

const router = useRouter();
const authStore = useAuthStore();

const selectedUser = ref(null as unknown) as Ref<User>;
selectedUser.value = {
    role: "unkown",
};
const view = "User";

async function onUserChanged(u: User) {
    selectedUser.value = u;
}
async function check() {
    const answer: boolean = await authStore.check();
    if (answer == false) {
        router.push("/login");
    }
}

onBeforeMount(() => {
    check();
});
</script>
<template>
    <main>
        <Sidebar @change:selection="onUserChanged" :view="view" />
        <div class="row">
            <div v-if="selectedUser.role == 'teilnehmende'" class="col 6">
                <Project :user="selectedUser" />
            </div>
            <div class="col 4 q-gutter-md q-pa-md">
                <Formular :user="selectedUser" :view="view" />
            </div>
        </div>
    </main>
</template>
<style></style>
