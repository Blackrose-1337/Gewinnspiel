<script setup lang="ts">
import type { Ref } from "vue";
import { ref, toRefs, watch } from "vue";
import Formular from "@/components/Formular.vue";
import Sidebar from "@/components/Sidebar.vue";
import Project from "@/components/Project.vue";
import type { User } from "@/stores/interfaces";

const selectedUser = ref(null as unknown) as Ref<User>;
selectedUser.value = {
    role: "unkown",
};
const view = "User";

function onUserChanged(u: User) {
    console.log("User: ", u);
    selectedUser.value = u;
}
</script>
<template>
    <main>
        <Sidebar @change:selection="onUserChanged" :view="view" />
        <div v-if="selectedUser.role == 'unkown' || selectedUser.role == 'jury'" class="q-gutter-md q-pa-md">
            <Formular :user="selectedUser" :view="view" />
        </div>
        <div v-else class="row">
            <div class="col 6">
                <Project :user="selectedUser" />
            </div>
            <div class="col 4 q-gutter-md q-pa-md">
                <Formular :user="selectedUser" :view="view" />
            </div>
        </div>
    </main>
</template>
<style></style>
