<script setup>
    import { useForm } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Keypad from '@/Components/Keypad.vue';
    import swal from 'sweetalert';

    const props = defineProps({
        role: {
            type: Object,
            default: () => ({}),
        },
        permissions: {
            type: Object,
            default: () => ({}),
        },
        roleHasPermissions: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        name: props.role.name,
        permissions: props.roleHasPermissions
    });

    const updateRol = () => {
        form.put(route('roles.update',props.role.id), {
            errorBag: 'updateRol',
            preserveScroll: true,
            onSuccess: () => {
                swal('Rol actualizado con éxito.');
            },
        });
    };

    const selectAllCheckbox = (event) => {
        if(event.target.checked){
            const allPermissions = props.permissions;
            for (let i = 0; i < allPermissions.length; i++) {
                form.permissions[i] = allPermissions[i].name;
            }
        }else{
            form.permissions = [];
        }
    }
</script>

<template>
    <FormSection @submitted="updateRol">
        <template #title>
            Roles Detalles
        </template>

        <template #description>
            Nuevo Rol
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="Nombre" value="Nombre" />
                <TextInput
                    id="Nombre"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6">
                <div class="flex items-center mb-6">
                    <input @change="selectAllCheckbox($event)" id="checkboxAll" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkboxAll" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Todos
                    </label>
                </div>
                <template v-for="(row, index) in permissions">
                    <div class="flex items-center">
                        <input v-model="form.permissions" :value="row.name" :id="'checkbox'+index" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label :for="'checkbox'+index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ row.name }}</label>
                    </div>
                </template>
            </div>
        </template>

        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar
                    </PrimaryButton>
                    <a :href="route('roles.index')"  class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out ml-2">Ir al Listado</a>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
