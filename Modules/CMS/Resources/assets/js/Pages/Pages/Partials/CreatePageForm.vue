<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Keypad from '@/Components/Keypad.vue';
import Swal2 from 'sweetalert2';
import { Dropdown } from 'flowbite-vue'

const props = defineProps({
    countries: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    description: null,
    icon: null,
    route: null,
    main: false,
    status : true,
    country_icon: null,
    country_description: 'Seleccionar país',
    country_id: null
});

const createPage = () => {
    form.post(route('cms_pages_store'), {
        errorBag: 'createPage',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se registró correctamente',
                icon: 'success',
            });
            form.reset()
        },
    });
}

const getImageCountry = (path) => {
    return assetUrl + path;
}

const setCountry = (id, text, icon) => {
    form.country_id = id;
    form.country_description = text;
    form.country_icon = assetUrl + icon;
}
</script>

<template>
    <FormSection @submitted="createPage" class="">
        <template #title>
            Pagina Detalles
        </template>

        <template #description>
            Crear nuevo pagina, Los campos con * son obligatorios
        </template>

        <template #form>
            <div class="col-span-6 ">
                <InputLabel value="País *" class="mb-1" />
                <dropdown>
                    <template #trigger="{ toggle }">
                    <button class="w-full flex-shrink-0 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button" @click="toggle">
                        <img v-show="form.country_icon" :src="form.country_icon" class="mr-1" style="width: 15px;"><span>{{ form.country_description }}</span> 
                    </button>
                    </template>
                    <div class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-full dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li v-for="(country, ke) in countries">
                                <button @click="setCountry(country.id,country.description,country.icon)" type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <div class="inline-flex items-center">
                                        <img :src="getImageCountry(country.icon)" class="h-3.5 w-3.5 rounded-full mr-2" >
                                        {{ country.description }}
                                    </div>
                                </button>
                            </li>
                        </ul>
                    </div>
                </dropdown>
                <InputError :message="form.errors.country_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="description" value="Descripción *" />
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="icon" value="Icono" />
                <TextInput
                    id="icon"
                    v-model="form.icon"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="fa-solid fa-check"
                />
                <InputError :message="form.errors.icon" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6 ">
                <InputLabel for="route" value="Ruta *" />
                <TextInput
                    id="route"
                    v-model="form.route"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.route" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6 ">
                <InputLabel for="route" value="¿Esta será la página de inicio?" />
                <div class="flex items-center mt-1">
                    <input v-model="form.main" id="inline-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="inline-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">SI</label>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-6 ">
                <InputLabel for="route" value="Activo" />
                <div class="flex items-center mt-1">
                    <input v-model="form.status" id="status" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="status" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">SI</label>
                </div>
            </div>
        </template>

        <template #actions>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Guardar
                    </PrimaryButton>
                    <Link :href="route('cms_pages_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>