<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import editForm from './Pertials/editForm.vue';

    const props = defineProps({
        categories: {
            type: Object,
            default: () => ({})
        },
        article: {
            type: Object,
            default: () => ({})
        },
        tiny_api_key: {
            type: String,
            default: null,
        }
    });
</script>

<template>
    <AppLayout title="Blog Nueva Articulo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Articulo
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <editForm :tiny_api_key="tiny_api_key" :article="article" :categories="categories"></editForm>
            </div>
        </div>
    </AppLayout>
</template>
