<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateForm from './Pertials/createForm.vue';

const props = defineProps({
    permissions: {
        type: Object,
        default: () => ({}),
    }
});
</script>

<template>
    <AppLayout title="Crear Rol">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo Rol
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateForm :permissions="permissions"></CreateForm>
            </div>
        </div>
    </AppLayout>
</template>
