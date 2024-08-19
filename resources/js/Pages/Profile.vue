<script setup>
import Vue from 'vue';
import {Tabs, Tab} from 'vue3-tabs-component';

Vue.component('tabs', Tabs);
Vue.component('tab', Tab);

</script>

<template>
    <div>
        <tabs>
            <tab name="Profile">
                Профиль
            </tab>
            <tab name="Cities">
                Города
            </tab>
        </tabs>
    </div>
</template>

<style scoped>

</style>
