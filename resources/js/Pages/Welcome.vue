<script setup>
import Header from '@/Components/Header.vue';

const props = defineProps({
    client: Object,
});

</script>

<template>
    <Header/>
    <div>
        {{ client }}
    </div>
</template>
