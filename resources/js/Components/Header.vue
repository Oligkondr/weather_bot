<script setup>
import { Link } from '@inertiajs/vue3';

import DropdownMenu from 'v-dropdown-menu';
import 'v-dropdown-menu/css';

defineProps({ user: Object });

</script>

<template>
    <div class="my-4 bg-gray-300 p-4 grid grid-cols-2 rounded-xl">
        <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-7">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
            </svg>
            <span class="ml-2 font-bold text-xl">
                Прогноз погоды
            </span>
        </div>
        <div class="flex justify-end">
            <Link v-if="!user" :href="route('login')">Войти</Link>
            <div v-else>
                <dropdown-menu mode="hover" direction="right" :overlay="false">
                    <template #trigger>
                        <button>{{ user.login }}</button>
                    </template>
                    <template #body>
                        <ul>
                            <li class="px-4 py-2">
                                <Link :href="route('profile.index')">Профиль</Link>
                            </li>
                            <li class="px-4 py-2">
                                <Link :href="route('logout')" method="post">Выйти</Link>
                            </li>
                        </ul>
                    </template>
                </dropdown-menu>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
