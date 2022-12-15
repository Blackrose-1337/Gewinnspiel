<script setup lang="ts">
import { ref, toRefs } from "vue";
import { useQuasar } from "quasar";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

const props = defineProps({
    redirectTo: {
        type: String,
        default: "/",
    },
});

const { redirectTo } = toRefs(props);
const $q = useQuasar();
const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const email = ref("");
const password = ref("");
const showPassword = ref(false);

function isValidEmail(val: string) {
    const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,7}$/;
    return emailPattern.test(val) || "Invalid email";
}
function isValidpw(val: string) {
    const pwpattern = /^[a-zA-Z0-9\@\+\?\!]{12,20}$/;
    console.log(val);
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
            await authStore.login(email.value, password.value);
            $q.notify("Login aktzeptiert");
            await router.push(redirectTo.value);
        } catch (err) {
            console.error("Login failed: ", err);
            $q.notify({
                message: "Login fehlgeschlagen",
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
                v-model="email"
                type="email"
                lazy-rules
                :rules="[val => (val && val.length > 0) || 'E-Mail is required']"
            />
            <q-input
                label="Password"
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
            <q-btn label="Login" class="q-mt-auto" color="primary" icon="login" @click="login" />
        </q-form>
    </q-page>
</template>

<style></style>
