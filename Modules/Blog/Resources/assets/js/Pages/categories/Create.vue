<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
import CreateForm from './Pertials/createForm.vue';


</script>

<template>
    <AppLayout title="Blog Nueva Categoria">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nueva Categoria
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateForm></CreateForm>
            </div>
        </div>
    </AppLayout>
</template>
