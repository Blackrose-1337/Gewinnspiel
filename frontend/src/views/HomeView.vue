<script setup lang="ts"></script>

<template>
    <main>
        <q-drawer show-if-above side="left" behavior="desktop" bordered>
            <RouterLink to="/">Home</RouterLink> <br />
            <RouterLink to="/helloworld">Hello World</RouterLink> <br />
            <RouterLink to="/login">Login</RouterLink> <br />
            <RouterLink to="/admin-survey">Umfrage</RouterLink> <br />
            <RouterLink to="/customer">Kundenansicht</RouterLink> <br />
        </q-drawer>
        <p></p>
    </main>
</template>
