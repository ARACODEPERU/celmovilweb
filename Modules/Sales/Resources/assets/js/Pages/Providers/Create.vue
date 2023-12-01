<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateProviderForm from './Partials/CreateProviderForm.vue';
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Proveedor
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateProviderForm />
            </div>
        </div>
    </AppLayout>
</template>
