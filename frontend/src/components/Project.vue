<script setup lang="ts">
import image from "@/components/icons/test.json";
import { propsToAttrMap } from "@vue/shared";
import type { User } from "@/stores/interfaces";
import { useProjectStore } from "@/stores/projects";
import { storeToRefs } from "pinia";
import { toRefs, ref, watch } from "vue";

const props = defineProps<{
    user?: User;
    view?: string;
}>();

//---------------Storeload------------------------------
const projectStore = useProjectStore();

//---------------storeToRefs------------------------------
//const { isAuthenticated } = storeToRefs(authStore);
const { project } = storeToRefs(projectStore);
const { user } = toRefs(props) as User;

const bsp: string[] = [];
var bild = new Image();

function load() {
    if (!user) {
    } else {
        projectStore.getProject(user.value.id);
    }
}
function loadimage() {
    image.src.forEach(element => {
        bild.src = element;
        bsp.push(bild.src);
    });
}

function expand($event: any) {
    console.log($event);
    if ($event.target.classList.contains("expandanimation")) {
        $event.target.classList.remove("expandanimation");
        $event.target.classList.add("reexpandanimation");
    } else {
        $event.target.classList.remove("reexpandanimation");
        $event.target.classList.add("expandanimation");
    }
    console.log("still in Production");
}
watch(user, changeuser => {
    load();
});

load();
loadimage();
</script>
<template>
    <div>
        <div class="texts q-pa-lg">
            <h3>{{ project.title }}</h3>
            <p>{{ project.text }}</p>
        </div>
        <div class="row q-gutter-lg">
            <img v-for="pic in bsp" class="minipic q-pa-md" :src="pic" :ratio="1" @click="expand($event)" />
        </div>
    </div>
</template>

<style>
.minipic {
    width: 20vw;
    height: 20vh;

    box-shadow: 0 1px 5px rgb(0 0 0 / 20%), 0 2px 2px rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%);
    /* min-height: 24px;
    min-width: 24px; */
    align-self: center;
    z-index: 999;
}

.fullimage {
    width: 100% !important;
    height: 100% !important;
    display: flex;
    position: absolute;
}

.texts {
    background-color: rgb(168, 153, 85);
    border-radius: 15px;
    margin: 10px;
}
.expandanimation {
    height: 90vh;
    width: 90vw;

    animation: expander 0.5s;
    position: fixed;
    left: 0;
    right: 0;
    top: 8vh;
    bottom: 0;
    margin: auto;
    z-index: 9999;
}
.reexpandanimation {
    height: 20vh;
    width: 20vw;

    animation: reexpander 0.3s;
}

@keyframes expander {
    0% {
        width: 20vw;
        height: 20vh;
    }
    100% {
        width: 90vw;
        height: 90vh;
    }
}
@keyframes reexpander {
    100% {
        width: 20vw;
        height: 20vh;
    }
}
</style>
