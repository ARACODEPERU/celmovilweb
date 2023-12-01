<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';

const sidebarToggle = ref(false);

const eventSidebarToggle = (parmt) => {
    sidebarToggle.value = parmt;
};
defineProps({
    title: String,
});

</script>

<template>
    <Head :title="title" />
    <div class="flex h-screen overflow-hidden">
        <Sidebar :sidebarToggle="sidebarToggle" @activateCakeButton="eventSidebarToggle"></Sidebar>
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden dark:bg-gray-700">
            <Header :sidebarToggle="sidebarToggle" @displaySidebarToggle="eventSidebarToggle" ></Header>
            <main>
                <slot />
            </main>
        
        </div>
        
    </div>
</template>
