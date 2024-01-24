<script setup>
    import { useForm, Link } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { library } from "@fortawesome/fontawesome-svg-core";
    import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";
    import Keypad from '@/Components/Keypad.vue';
    import swal from 'sweetalert';
    import { 
        ConfigProvider, Select
    } from 'ant-design-vue';

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

    const form = useForm({
        name: props.xuser.name,
        email: props.xuser.email,
        password: props.xuser.password,
        local_id: props.xuser.local_id,
        role: props.xrole
    });

    const updateUser = () => {
        form.put(route('users.update', props.xuser.id), {
            errorBag: 'updateUser',
            preserveScroll: true,
            onSuccess: () => {
                swal('Usuario Modificado con éxito');
            }
        });
    };

    library.add(faTrashAlt);

</script>

<template>
    <FormSection @submitted="updateUser">
        <template #title>
            Datos de Usuario
        </template>

        <template #description>
            Editar usuario
        </template>

        <template #form>
            <ConfigProvider>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="stablishment" value="Establecimiento" />
                    <select v-model="form.local_id" id="stablishment" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <template v-for="(establishment, index) in props.establishments" :key="index">
                            <option :value="establishment.id">{{ establishment.description }}</option>
                        </template>
                    </select>
                    <InputError :message="form.errors.local_id" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="name" value="Nombre" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="block w-full mt-1"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="text"
                        class="block w-full mt-1"
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="text"
                        class="block w-full mt-1"
                        autofocus
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="rol" value="Rol" />
                    <Select
                        v-model:value="form.role"
                        mode="multiple"
                        style="width: 100%"
                        placeholder="Please select"
                        :options="roles.map((obj) => ({ value: obj.name, label: obj.name }))"
                    ></Select>
                    <InputError :message="form.errors.rol" class="mt-2" />
                </div>
            </ConfigProvider>
        </template>

        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar
                    </PrimaryButton>
                    <Link :href="route('users.index')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
