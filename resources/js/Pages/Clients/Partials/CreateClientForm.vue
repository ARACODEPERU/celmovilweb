<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Select, TreeSelect } from 'ant-design-vue';

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

const form = useForm({
    full_name: '',
    number: '',
    telephone: '',
    email: '',
    address: '',
    document_type_id: null,
    id:''
});

const searchPerson = async () => {
        axios.post(route('search_person'), form ).then((res) => {
            form.full_name = res.data.full_name;
            form.telephone = res.data.telephone;
            form.email = res.data.email;
            form.address = res.data.address;
            form.document_type_id = res.data.document_type_id;
            form.number = res.data.number;
            form.id = res.data.id;
        });
    };

const createClient = () => {
    form.post(route('clients.store'), {
        forceFormData: true,
        errorBag: 'createClient',
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const filterOption = (input, option) => {
    const inputValueLower = input.toLowerCase();
    const optionTitleLower = option.label.toLowerCase();
    return optionTitleLower.includes(inputValueLower);
};

</script>

<template>
    <FormSection @submitted="createClient">
        <template #title>
            Cliente Detalles
        </template>

        <template #description>
            Ingresar nuevo cliente
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
                        <option v-for="(item, key) in identityDocumentTypes" :value="item.id">{{ item.description }}</option>
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
                <form @submit.prevent="searchPerson()">
                    <div class="">
                        <input v-model="form.number" autocomplete="off" type="search" id="search" style="display:none" class="" placeholder="Buscar Producto" required>
                        <button type="submit" class="block w-full bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-6">Buscar por Nro</button>
                    </div>
                </form>
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
                <InputLabel v-if="form.document_type_id==6" for="full_name" value="Razón Social" />
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
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="city" value="Ciudad" />
                <Select
                    v-model:value="form.ubigeo"
                    style="width: 100%"
                    :options="ubigeo.map((obj) => ({value:obj.district_id,label: obj.department_name+'-'+obj.province_name+'-'+obj.district_name,distric_name: obj.district_name }))"
                    show-search
                    :filter-option="filterOption"
                ></Select>
                <InputError :message="form.errors.address" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </PrimaryButton>
            <a :href="route('clients.index')"  class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out ml-2">Ir al Listado</a>
        </template>
    </FormSection>
</template>
