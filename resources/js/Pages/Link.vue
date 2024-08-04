<script setup>

defineProps({
    client: Object,
});


</script>

<template>
<div>
    {{ client.ext_id }}
    {{ client.first_name }}
    {{ client.last_name }}
    {{ client.username }}
</div>
</template>

<style scoped>

</style>
