<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import CreateUserForm from '@/Pages/Users/Partials/CreateUserForm.vue';

    const props = defineProps({
        establishments: {
            type: Object,
            default: () => ({}),
        },
        roles: {
            type: Object,
            default: () => ({}),
        }
    });

</script>

<template>
    <AppLayout title="Crear Usuario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo Usuario
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateUserForm :establishments="props.establishments" :roles="roles" />
            </div>
        </div>
    </AppLayout>
</template>
