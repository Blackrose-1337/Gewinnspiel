<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import type { Ref } from "vue";
import { ref } from "vue";
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";
import type { User } from "@/stores/interfaces";

const router = useRouter();
const route = useRoute();

const selectedUser = ref(null as unknown) as Ref<User>;
selectedUser.value = {
    id: "4",
};
</script>
<template>
    <main class="row q-gutter-lg">
        <div class="q-gutter-lg col-6">
            <Project />
        </div>
        <div class="q-gutter-lg col-5">
            <Formular :user="selectedUser" />
        </div>
    </main>
</template>
<style></style>
