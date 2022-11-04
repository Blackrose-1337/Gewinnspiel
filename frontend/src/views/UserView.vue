<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import Project from "@/components/Project.vue";
import Formular from "@/components/Formular.vue";

const router = useRouter();
const route = useRoute();
</script>
<template>
    <main class="row q-gutter-lg" >
        <div class="q-gutter-lg col-6">
            <Project />
        </div>
        <div class="q-gutter-lg col-5">
            <Formular  />
        </div>
        
       
    </main>
</template>
<style></style>