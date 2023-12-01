<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import EditUserForm from '@/Pages/Users/Partials/EditUserForm.vue';

    const props = defineProps({
        establishments: {
            type: Object,
            default: () => ({}),
        },
        xuser:{
            type: Object,
            default: () => ({}),
        },
		xrole:{
            type: Object,
            default: () => ({}),
        },
        roles:{
            type: Object,
            default: () => ({}),
        }
    });

</script>

<template>
    <AppLayout title="Crear Usuario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Usuario
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditUserForm 
                    :roles = "roles" 
                    :establishments = "props.establishments" 
                    :xuser = "props.xuser"
                    :xrole = "props.xrole"
                     />
            </div>
        </div>
    </AppLayout>
</template>
