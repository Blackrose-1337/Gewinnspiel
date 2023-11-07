<script setup lang="ts">
import type { Project } from "@/stores/interfaces";
import { computed, toRefs } from "vue";
import { useUserStore } from "@/stores/users";
import { storeToRefs } from "pinia";

//---------------Storeload------------------------------

//---------------storeToRefs------------------------------
const props = defineProps<{ project: Project; selected: boolean }>();
const { project, selected } = toRefs(props);
//---------------Storeload------------------------------
const userStore = useUserStore();

//---------------storeToRefs------------------------------
const { users } = storeToRefs(userStore);
const fullname = computed(() => getUser(project.value.userId) + " " + project.value.id);
const emit = defineEmits<{
    (event: "select"): void;
}>();
//---------------Functions------------------------------
function getUser(id: number) {
    const user = users.value.find(u => u.id == id);
    return user?.surname + " " + user?.name;
}
//---------------Executions------------------------------
</script>
<template>
    <div v-if="project.finish === 1" class="full-width q-pa-none">
        <q-btn
            v-if="users.length"
            class="full-width q-pa-none"
            bordered
            :style="{ background: selected ? '#09deed' : '#37ed09' }"
            @click="emit('select')"
            >{{ fullname }}</q-btn
        >
    </div>
    <div v-else class="full-width q-pa-none">
        <q-btn
            v-if="users.length"
            class="full-width q-pa-none"
            bordered
            :style="{ background: selected ? '#09deed' : '#D9D9D9FF' }"
            @click="emit('select')"
            >{{ fullname }}</q-btn
        >
    </div>
</template>
<style></style>
