<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import EditForm from '@/Pages/Establishments/Partials/EditForm.vue';

    const props = defineProps({
        users: {
            type: Object,
            default: () => ({}),
        },
        local:{
            type: Object,
            default: () => ({}),
        },
        seller:{
            type: Object,
            default: () => ({}),
        },
        ubigeo: {
            type: Object,
            default: () => ({}),
        }
    });

</script>

<template>
    <AppLayout title="Editar Tienda">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Tienda
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditForm :users="users" :local="local" :seller="seller" :ubigeo="ubigeo" />
            </div>
        </div>
    </AppLayout>
</template>
