<script setup lang="ts">
import Formular from "@/components/Formular.vue";
import Sidebar from "@/components/Sidebar.vue";
import Project from "@/components/Project.vue";
import type { Ref } from "vue";
import { ref, toRefs, watch } from "vue";
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
        <div v-if="selectedUser.role == 'unkown' || selectedUser.role == 'jury'" class="row q-gutter-md q-pa-md">
            <Formular :user="selectedUser" :view="view" />
        </div>
        <div v-if="selectedUser.role == 'teilnehmende'" class="row">
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

<!-- import { ref } from "vue";
import type { Ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import ValueRangeSidebar from "@/components/ValueRangeSidebar.vue";
import ValueRangeWorkspace from "@/components/ValueRangeWorkspace.vue";
import type { ValueRange } from "@/stores/interfaces";

const router = useRouter();
const route = useRoute();

const selectedValueRange = ref(null as unknown) as Ref<ValueRange>;

function onValueRangeChanged(vr: ValueRange) {
    console.log("vr: ", vr);
    selectedValueRange.value = vr;
}
</script>
<template>
    <main class="fit">
        <ValueRangeSidebar @change:selection="onValueRangeChanged" />
        <ValueRangeWorkspace class="row full-width"  />
    </main>
</template> -->
