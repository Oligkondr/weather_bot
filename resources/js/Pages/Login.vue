<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    errors: Object,
});
const form = reactive({
    login: null,
});

function submit () {
    router.post(route('send', []), form);
    form.code = null;
}

</script>

<template>
    <div class="p-2">
        {{ errors }}
        <form @submit.prevent="submit">
            <div>
                <input type="text" v-model="form.login" class="mt-2 rounded" placeholder="Логин" required>
            </div>
            <button type="submit" class="mt-2 p-2 rounded bg-gray-200">Отправить</button>
        </form>
    </div>
</template>

<style scoped>

</style>
