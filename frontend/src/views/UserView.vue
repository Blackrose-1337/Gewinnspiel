<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import type { Ref } from "vue";
import { ref } from "vue";
import { storeToRefs } from "pinia";
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";
import type { User } from "@/stores/interfaces";
import { useUserStore } from "@/stores/users";

const router = useRouter();
const route = useRoute();

const userStore = useUserStore();
const { user } = storeToRefs(userStore);

const selectedUser = ref(null as unknown) as Ref<User>;
selectedUser.value = {
    id: "5",
};

async function loaduser() {
    await userStore.getUser(selectedUser.value.id);
    console.log(user);
}
loaduser();
</script>
<template>
    <main class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Project :user="selectedUser" />
        </div>
        <div class="q-gutter-lg col-5">
            <Formular :user="user" />
        </div>
    </main>
</template>
<style></style>
