<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import EditClientForm from '@/Pages/Clients/Partials/EditClientForm.vue';

    defineProps({
        client: {
            type: Object,
            default: () => ({}),
        }
    });
</script>

<template>
    <AppLayout title="Editar cliente">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Cliente
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditClientForm
                    :client="client"
                />
            </div>
        </div>
    </AppLayout>
</template>
