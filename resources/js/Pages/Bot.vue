<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    client: Object,
    errors: Object,
});

const form = reactive({
    login: props.client.username,
    code: null,
});

function submit () {
    router.post(route('telegram.bind', [props.client.id]), form);
    form.code = null
}

</script>

<template>
    <div class="flex justify-center items-center h-screen">
        <form @submit.prevent="submit" class="p-6 bg-gray-100 rounded-xl shadow-lg">
            <div>
                <label>Введите ваш логин:</label>
                <input type="text" v-model="form.login" class="mt-2 rounded w-full" placeholder="Логин" required>
            </div>
            <div>
                <label>Введите код из бота:</label>
                <input type="text" v-model="form.code" class="mt-2 rounded w-full" placeholder="Код" required>
            </div>
            <button type="submit" class="shadow-lg mt-4 mr-2 py-2 px-4 rounded bg-blue-600 hover:bg-blue-800 transition-colors duration-200 text-white font-bold">Отправить</button>
        </form>
    </div>
</template>

<style scoped>

</style>
