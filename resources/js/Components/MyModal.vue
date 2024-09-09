<script setup>
defineProps({
    name: String,
    action: Number,
    isOpen: Boolean,
});
</script>

<template>
    <div v-show="isOpen" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-10">
        <div class="max-w-2xl p-6 mx-4 bg-white rounded-md shadow-xl">
            <div @click="$emit('close')" class="flex items-center justify-between">
                <h3 class="text-2xl">{{name}}</h3>
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8 text-red-900 cursor-pointer" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <slot/>

            <div class="mt-4">
                <button @click="$emit('close')" class="px-6 py-2 text-blue-800 border border-blue-600 rounded">
                    Отмена
                </button>
                <button @click="$emit('action')" class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
