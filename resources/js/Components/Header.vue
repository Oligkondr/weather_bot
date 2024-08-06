<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ user: Object });

</script>

<template>
    <div class="bg-[#1f2937] p-4 text-white">
        <Link v-if="user" href="/logout" method="post">Выйти</Link>
        <Link v-else href="/login">Войти</Link>
    </div>
</template>

<style scoped>
p {
    background-color: #9ab5d5;
}
</style>
