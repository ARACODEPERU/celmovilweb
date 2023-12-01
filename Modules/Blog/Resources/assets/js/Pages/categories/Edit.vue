<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import editForm from './Pertials/editForm.vue';

const props = defineProps({
    category: {
        type: Object,
        default: () => ({}),
    }
});
</script>

<template>
    <AppLayout title="Blog Nueva Categoria">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Categoria
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <editForm :category="category"></editForm>
            </div>
        </div>
    </AppLayout>
</template>
