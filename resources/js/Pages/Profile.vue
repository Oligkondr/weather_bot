<script setup>
import axios from 'axios';
import { computed, reactive, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import MyModal from '@/Components/MyModal.vue';

let isOpen = ref(false);

const page = usePage();

const user = computed(() => page.props.auth.user);

defineProps({ cities: Array });

const deleteCity = (id) => {
    if (confirm('Удалить?')) {
        axios.delete(route('profile.city.delete', [id]))
            .then(() => {
                router.visit(route('profile.index'), {
                    only: ['cities'],
                });
            });
    }
};

const form = reactive({
    city: null,
});

const addCity = () => {
    axios.post(route('profile.city.create', []), form)
        .then(response => {
            const data = response.data;
            form.city = null;
            isOpen.value = false;
            if (data.success) {
                router.visit(route('profile.index'), {
                    only: ['cities'],
                });
            } else {
                alert(data.message);
            }
        });
};
</script>

<template>
    <Layout>
        <div>
            <tabs>
                <tab name="Профиль">
                    <div>
                        <div>Имя: {{ user.first_name }}</div>
                    </div>
                    <div>Фамилия: {{ user.last_name }}</div>
                </tab>
                <tab name="Ваши города">
                    <button class="px-3 py-2 rounded bg-green-500 flex" @click="isOpen = true">
                        <span class="text-white text-xl">Добавить город</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="ml-2 size-7 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </button>

                    <MyModal name="Добавить город" :is-open="isOpen" @close="isOpen = false" @action="addCity">
                        <input class="mt-3" v-model="form.city" placeholder="Введите новый город">
                    </MyModal>

                    <ul class="w-1/4">
                        <li v-for="city in cities" class="flex my-2 py-2 px-3 rounded bg-gray-100">
                            <span class="flex-1 mr-2">
                                {{ city.name }}
                            </span>
                            <button class="text-red-500" @click="deleteCity(city.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </tab>
            </tabs>
        </div>
    </Layout>
</template>

<style scoped>

</style>
