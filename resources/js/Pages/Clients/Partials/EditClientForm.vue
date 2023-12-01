<script setup>
    import { useForm } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { library } from "@fortawesome/fontawesome-svg-core";
    import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";

    const props = defineProps({
        client: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        full_name: props.client.full_name,
        number: props.client.number,
        document_type_id: props.client.document_type_id,
        telephone: props.client.telephone,
        email: props.client.email,
        address: props.client.address

    });

    const editClient = () => {
        form.put(route('clients.update', props.client.id), {
            //forceFormData: true,
            errorBag: 'editClient',
            preserveScroll: true,
        });
    };

    library.add(faTrashAlt);

</script>

<template>
    <FormSection @submitted="editClient">
        <template #title>
            Cliente Detalles
        </template>

        <template #description>
            Editar Cliente
        </template>

        <template #form>
            <div class="col-span-4 sm:col-span-2">
                        <InputLabel value="Tipo de Documento" class="mb-1" />
                        <select class="form-select appearance-none
                            block
                            w-full
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding bg-no-repeat
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            v-model="form.document_type_id"
                            >
                                <option value="" selected>Seleccionar</option>
                                    <option :value="1" @click="document_type_id=1">DNI</option>
                                    <option :value="6" @click="document_type_id=6">RUC</option>
                                    <option :value="0" @click="document_type_id=0">Otros</option>
                          </select>
                        <InputError :message="form.errors.document_type_id" class="mt-2" />
             </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="number" value="Número de Doc." />
                <TextInput
                    id="number"
                    v-model="form.number"
                    type="number"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.number" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="telephone" value="Teléfono" />
                <TextInput
                    id="telephone"
                    v-model="form.telephone"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.telephone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel v-if="document_type_id==6" for="full_name" value="Razón Social" />
                <InputLabel v-else for="full_name" value="Nombres" />
                <TextInput
                    id="full_name"
                    v-model="form.full_name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.full_name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="address" value="Dirección" />
                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.address" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Actualizar
            </PrimaryButton>
            <a :href="route('clients.index')"  class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out ml-2">Ir al Listado</a>
        </template>
    </FormSection>
</template>
