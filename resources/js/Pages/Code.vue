<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    login: String,
    errors: Object,
});

const form = reactive({
    code: null,
});

function submit () {
    router.post(route('auth', [props.login]), form);
    form.code = null;
}

const newCode = () => {
    axios.get(route('telegram.code', [props.login]));
};

</script>

<template>
    <div class="flex justify-center items-center h-screen">
        <form @submit.prevent="submit" class="p-6 bg-gray-100 rounded-xl shadow-lg">
            <div>
                <label>Введите код из бота:</label>
                <input type="text" v-model="form.code" class="mt-2 rounded w-full" placeholder="Код" required>
            </div>
            <button type="submit" class="shadow-lg mt-4 mr-2 py-2 px-4 rounded bg-blue-600 hover:bg-blue-800 transition-colors duration-200 text-white font-bold">Отправить</button>
            <button type="button" class="mt-4 py-2 px-4 text-blue-900 dash transition-colors hover:text-blue-600" @click="newCode">Отправить новый код</button>
        </form>
    </div>
</template>

<style scoped>

</style>
