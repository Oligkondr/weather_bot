<script setup>
import { Link } from '@inertiajs/vue3';

import DropdownMenu from 'v-dropdown-menu';
import 'v-dropdown-menu/css';

defineProps({ user: Object });

</script>

<template>
    <div class="my-4 bg-gray-300 p-4 grid rounded-xl">
        <div class="flex justify-end">
            <Link v-if="!user" :href="route('login')">Войти</Link>
            <div v-else>
                <dropdown-menu mode="hover" direction="right" :overlay="false">
                    <template #trigger>
                        <button>{{ user.login }}</button>
                    </template>

                    <!--                <template #header> Dropdown Header </template>-->

                    <template #body>
                        <ul>
                            <li class="px-4 py-2">
                                <Link :href="route('profile')">Профиль</Link>
                            </li>
                            <li class="px-4 py-2">
                                <Link :href="route('logout')" method="post">Выйти</Link>
                            </li>
                        </ul>
                    </template>

                    <!--                <template #footer> Dropdown Footer </template>-->
                </dropdown-menu>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
