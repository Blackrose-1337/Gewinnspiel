<script setup lang="ts">
import image from "@/components/icons/test.json";

const bsp: string[] = [];
var bild = new Image();
function test() {
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

test();
</script>
<template>
    <div class="row q-gutter-lg">
        <img v-for="pic in bsp" class="minipic q-pa-md" :src="pic" :ratio="1" @click="expand($event)" />
    </div>
    <div class="texts q-gutter-lg">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad quae dicta officia ea libero, corrupti commodi
            eligendi molestias sed est ab explicabo maiores unde illum, facere, deserunt atque provident error. omnis
            quidem earum vero nobis esse vitae soluta veniam eaque. Error, cum. Perferendis, asperiores tempora maxime
            aut provident dignissimos minus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, amet
            voluptas nobis nesciunt necessitatibus molestiae dolores nostrum accusantium ut placeat vero eligendi.
            Sapiente distinctio aliquid voluptatum provident vel, consequatur corporis? Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Esse dolores numquam, asperiores excepturi, minus, saepe quibusdam labore a
            adipisci eos ut consequuntur voluptas ullam fugiat quidem accusamus architecto officiis sint! Lorem ipsum,
            dolor sit amet consectetur adipisicing elit. Iusto est minima doloribus nisi sunt dolorum ratione, officiis,
            expedita deleniti dignissimos veritatis vero tenetur fugiat ea eos dolor nam itaque rem. Lorem ipsum dolor
            sit amet consectetur, adipisicing elit. Facilis ut voluptas excepturi odio eligendi quia quasi placeat iure
            obcaecati ipsum magnam tempora minima ullam at deserunt vero, aliquid esse vel. Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Nulla deleniti ea quidem suscipit autem! Ullam vitae illo unde tempora veniam.
            Maiores saepe sequi odio ea impedit, molestiae voluptatibus mollitia architecto! omnis quidem earum vero
            nobis esse vitae soluta veniam eaque. Error, cum. Perferendis, asperiores tempora maxime aut provident
            dignissimos minus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, amet voluptas nobis
            nesciunt necessitatibus molestiae dolores nostrum accusantium ut placeat vero eligendi. Sapiente distinctio
            aliquid voluptatum provident vel, consequatur corporis? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Esse dolores numquam, asperiores excepturi, minus, saepe quibusdam labore a adipisci eos ut
            consequuntur voluptas ullam fugiat quidem accusamus architecto officiis sint! Lorem ipsum, dolor sit amet
            consectetur adipisicing elit. Iusto est minima doloribus nisi sunt dolorum ratione, officiis, expedita
            deleniti dignissimos veritatis vero tenetur fugiat ea eos dolor nam itaque rem. Lorem ipsum dolor sit amet
            consectetur, adipisicing elit. Facilis ut voluptas excepturi odio eligendi quia quasi placeat iure obcaecati
            ipsum magnam tempora minima ullam at deserunt vero, aliquid esse vel. Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Nulla deleniti ea quidem suscipit autem! Ullam vitae illo unde tempora veniam.
            Maiores saepe sequi odio ea impedit, molestiae voluptatibus mollitia architecto!
        </p>
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
