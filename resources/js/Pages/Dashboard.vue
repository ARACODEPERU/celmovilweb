<script setup>
import Welcome from '@/Components/Welcome.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Shortcuts from '@/Components/Shortcuts.vue';

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    <Welcome />
                </div>
                <div class="bg-white overflow-hidden mt-4">
                    <Shortcuts />
                </div>
            </div> -->

        </div>
    </AppLayout>
</template>
