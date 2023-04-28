<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import { useQuasar } from "quasar";
import { useAuthStore } from "@/stores/auth";
import { useUserStore } from "@/stores/users";
import { useRouter } from "vue-router";

const $q = useQuasar();
const authStore = useAuthStore();
const router = useRouter();
const email = ref(import.meta.env.MODE === "production" ? "" : "");
const password = ref(import.meta.env.MODE === "production" ? "" : "");
const showPassword = ref(false);
const OptIn = ref(false);

function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9äöüÄÖÜ@._%+-]{6,254}$)[a-zA-Z0-9äöüÄÖÜ._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}
function isValidpw(val: string) {
    const pwpattern = /^[a-zA-Z0-9!@#$%^*()_+-={}|:,.<>?]{12,30}$/;
    return pwpattern.test(val) || "Invalid password";
}
async function check() {
    const answer: boolean = await authStore.check();
    if (!answer) {
        router.push("/login");
    } else if (authStore.role != "admin") {
        $q.notify({
            type: "negative",
            message: "Keine Berechtigung für diese Seite",
            color: "red",
        });
        router.push("/");
    }
}

async function changePw() {
    if (isValidEmail(email.value) != true) {
        $q.notify({
            message: "Email ist inakzeptabel",
            type: "negative",
        });
    } else if (isValidpw(password.value) != true) {
        $q.notify({
            message: "Passwort ist inakzeptabel",
            type: "negative",
        });
    } else {
        const answer = await useUserStore().setPW(email.value, password.value, OptIn.value);
        if (answer["answer"] == true) {
            $q.notify({
                type: "positive",
                message: "Passwort wurde geändert",
                color: "green",
            });
        } else {
            $q.notify({
                type: answer["type"],
                message: answer["message"],
            });
        }
    }
}
onBeforeMount(() => {
    check();
});
</script>

<template>
    <q-page class="q-pa-xl">
        <span class="text-h5">Passwortverwaltung</span>

        <q-form ref="form">
            <q-input
                label="E-Mail"
                standout="bg-secondary"
                label-color="accent"
                outlined
                v-model="email"
                type="email"
                autofocus
                lazy-rules
                :rules="[val => (val && val.length > 0) || 'E-Mail is required']"
            />
            <q-input
                label="Password"
                standout="bg-secondary"
                label-color="accent"
                outlined
                v-model="password"
                :type="!showPassword ? 'password' : 'text'"
                :rules="[val => (val && val.length > 0) || 'Password is required']"
            >
                <template v-slot:append>
                    <q-icon
                        :name="!showPassword ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="showPassword = !showPassword"
                    />
                </template>
            </q-input>
            <p class="text-accent">Passwort muss min. 12 Zeichen besitzen</p>
            <q-field class="q-pb-lg" v-model="OptIn" color="accent" ref="checkRef" dense borderless>
                <q-checkbox
                    standout="bg-secondary"
                    color="accent"
                    right-label
                    v-model="OptIn"
                    label="Opt-In bestätigen"
                    class="col-4"
                />
            </q-field>
            <q-btn label="Ändern" class="q-mt-auto" color="accent" icon="lock_reset" @click="changePw" />
        </q-form>
    </q-page>
</template>

<style></style>
