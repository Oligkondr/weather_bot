<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

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
    <div class="p-2">
        {{ errors }}
        <form @submit.prevent="submit">
            <div>
                <input type="text" v-model="form.login" class="mt-2 rounded" placeholder="Логин" required>
            </div>
            <div>
                <input type="text" v-model="form.code" class="mt-2 rounded" placeholder="Код" required>
            </div>
            <button type="submit" class="mt-2 p-2 rounded bg-gray-200">Отправить</button>
        </form>
    </div>
</template>

<style scoped>

</style>
