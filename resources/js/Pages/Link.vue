<script setup>

defineProps({
    client: Object,
});


</script>

<template>
    <div>
        {{ client.ext_id }}
    </div>
    <div>
        {{ client.first_name }}
    </div>
    <div>
        {{ client.last_name }}
    </div>
    <div>
        {{ client.username }}
    </div>
    <div>
        {{ client.username }}
    </div>
    <div>
        {{ client.verification_code}}
    </div>
</template>

<style scoped>

</style>
