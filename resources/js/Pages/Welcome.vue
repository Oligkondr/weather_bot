<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';

const page = usePage();

const user = computed(() => page.props.auth.user);

</script>

<template>
    <Layout>
        <div>
            {{ user }}
        </div>
    </Layout>
</template>
