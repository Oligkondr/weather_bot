<script setup>
import Header from '@/Components/Header.vue';

import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const user = computed(() => page.props.auth.user);

</script>

<template>
    <Header :user="user"/>
    <slot/>
</template>

<style scoped>

</style>
