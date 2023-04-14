<script setup lang="ts">
import { ref } from "vue";
import { useQuasar } from "quasar";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const redirectTo = ref();
const $q = useQuasar();
const authStore = useAuthStore();
const router = useRouter();
const email = ref(import.meta.env.MODE === "production" ? "" : "poppel@gmx.ch");
const password = ref(import.meta.env.MODE === "production" ? "" : "exampel1DDH?");
const showPassword = ref(false);

function isValidEmail(val: string) {
    const emailPattern =
	    /^(?=[a-zA-Z0-9äöüÄÖÜ@._%+-]{6,254}$)[a-zA-Z0-9äöüÄÖÜ._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}
function isValidpw(val: string) {
    const pwpattern = /^[a-zA-Z0-9!@#$%^*()_+-={}|:,.<>?]{12,20}$/;
    return pwpattern.test(val) || "Invalid password";
}

async function login() {
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
        try {
            const answer = await authStore.login(email.value, password.value);
            if (answer) {
                $q.notify({
                    message: "Login aktzeptiert",
                    type: "positive",
                });
                switch (authStore.role) {
                    case "teilnehmende": {
                        redirectTo.value = "/user";
                        break;
                    }
                    case "jury": {
                        redirectTo.value = "/evaluation";
                        break;
                    }
                    case "admin": {
                        redirectTo.value = "/verwaltung";
                        break;
                    }
                }
                await router.push(redirectTo.value);
            } else {
                $q.notify({
                    message: answer.error,
                    type: answer.success,
                });
                authStore.role = answer.role;
                await router.push(redirectTo.value);
            }
        } catch (err) {
            console.error("Login failed: ", err);
            $q.notify({
                message: "Login fehlgeschlagen\n",
                type: "negative",
            });
        }
    }
}
</script>

<template>
    <q-page class="q-pa-xl">
        <span class="text-h5">Login</span>

        <q-form ref="form">
            <q-input
                label="E-Mail"
                standout="bg-secondary"
                label-color="accent"
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
            <q-btn label="Login" class="q-mt-auto" color="accent" icon="login" @click="login" />
        </q-form>
    </q-page>
</template>

<style></style>
