<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import InformationForm from './Partials/InformationForm.vue';

const props = defineProps({
    company: {
        type: Object,
        default: () => ({}),
    },
    ubigeo: {
        type: Object,
        default: () => ({})
    },
});
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mi empresa
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <InformationForm :company="company" :ubigeo="ubigeo"></InformationForm>
            </div>
        </div>
    </AppLayout>
</template>
