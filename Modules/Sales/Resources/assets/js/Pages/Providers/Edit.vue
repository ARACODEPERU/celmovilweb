<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import EditProviderForm from './Partials/EditProviderForm.vue';

    defineProps({
        provider: {
            type: Object,
            default: () => ({}),
        }
    });
</script>

<template>
    <AppLayout title="Edit Provider">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Proveedor
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditProviderForm
                    :provider="provider"
                />
            </div>
        </div>
    </AppLayout>
</template>
