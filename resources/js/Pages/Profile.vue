<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';

const page = usePage();

const user = computed(() => page.props.auth.user);

defineProps({ cities: Array });
</script>

<template>
    <Layout>
        <div>
            <tabs>
                <tab name="Profile">
                    <div>
                        <div>Имя: {{ user.first_name }}</div>
                    </div>
                    <div>Фамилия: {{ user.last_name }}</div>
                </tab>
                <tab name="Cities">
                    <ul class="w-1/4">
                        <li v-for="city in cities" class="flex my-2 py-2 px-3 rounded bg-gray-100">
                            <span class="flex-1 mr-2">
                                {{ city.name }}
                            </span>
                            <button class="text-red-500">
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
