<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateClientForm from '@/Pages/Clients/Partials/CreateClientForm.vue';

const props = defineProps({
    identityDocumentTypes: {
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
    <AppLayout title="Crear Cliente">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo Cliente
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateClientForm :identityDocumentTypes="identityDocumentTypes" :ubigeo="ubigeo" />
            </div>
        </div>
    </AppLayout>
</template>
