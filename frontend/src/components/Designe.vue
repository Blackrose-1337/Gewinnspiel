<script setup lang="ts">
import { ref } from "vue";
import { storeToRefs } from "pinia";
import { useQuasar } from "quasar";
import Formular from "@/components/Formular.vue";
import type { Wettbewerb } from "@/stores/interfaces"



const wettbewerb :Wettbewerb= ref({
    id: 0,
    title: "",
    Wettbewerbtext: "",
    Wettbewerbbeginn: "",
    Wettbewerbende: "",
    WettbewerbCloseText: "",
})


</script>

<template>
    <h3>
        <q-input v-model="wettbewerb.title" label="Titel vom Projekt" />
    </h3>
    <div class="q-pa-md">
        <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Labore ullam optio praesentium in veniam eligendi
            voluptas libero, obcaecati sint doloribus!Lorem Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Dolore ipsum saepe possimus earum illo nihil nisi quia eum eius nobis labore officia, quo nemo repellendus.
            Voluptas nesciunt delectus beatae eum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem,
            nam incidunt ab deleniti nulla, officiis obcaecati, qui iusto vitae perspiciatis magnam a cum. Esse,
            possimus vel illo ullam ratione sed. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium
            similique exercitationem eum incidunt atque rerum iusto voluptas placeat, sint expedita molestias quae ipsa
            nam sapiente accusamus praesentium recusandae perspiciatis. Quod!
        </p>
    </div>

    <div class="row q-pa-md">
        <div class="col-4" style="max-width: 30%">
            <q-input v-model="textbsp.text" label="Beschreibung zum Projekt" autogrow />
        </div>
        <div class="col-1"></div>

        <div class=" muh row col-7 q-gutter-md">
            <Formular />

            <q-uploader
                class="col-11"
                max-files="3"
                url="http://localhost:4444/upload"
                label="Filtered (png only)"
                multiple
                :filter="checkFileType"
                @rejected="onRejected"
            />
            <q-checkbox
                left-label
                v-model="teilnahmebedingungenbestätigung"
                label="Teilnahmebedingungen"
                class="col-4"
            />
            <q-space />
            <q-btn label="Senden" color="green" class="col-3" />
        </div>
    </div>

    <div bordered elevated class="bg-grey-8k">
        <h5>Teilnahmebedingungen</h5>
    
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque necessitatibus quaerat impedit minima
            praesentium! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates dolore illum rerum. Ipsum
            ab earum perferendis voluptatibus natus? Labore, pariatur inventore. Aliquam nulla autem eligendi ad
            perspiciatis molestias inventore error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi rerum
            iusto, nisi eaque ab repudiandae modi accusamus quia, facilis neque laborum eum at nemo? Earum eaque fugit
            cumque reprehenderit inventore. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sapiente quis
            porro et delectus ex debitis blanditiis! Facere expedita quae autem totam ab! Consequuntur facilis quo
            excepturi amet, voluptates dignissimos autem.
        </p>
    </div>
</template>