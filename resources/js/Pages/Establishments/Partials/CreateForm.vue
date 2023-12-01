<script setup>
    import { useForm,Link } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref } from "vue";
    import swal from 'sweetalert';
    import Keypad from '@/Components/Keypad.vue';

    const props = defineProps({
        ubigeo: {
            type: Object,
            default: () => ({})
        },
        users: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        description: null,
        address: null,
        phone: null,
        user_id: null,
        ubigeo: null,
        ubigeo_description: null,
        map: null,
        agent: null,
        email: null,
        image: null,
        image_view: null
    });

    const createEstablishment = () => {
        form.post(route('establishments.store'), {
            forceFormData: true,
            errorBag: 'createEstablishment',
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                swal('Tienda creada con éxito');
            }
        });
    };
    const searchUbigeos = ref([]); // Inicializa searchUbigeos como una matriz vacía en lugar de null

    const filterCities = () => {
        if (form.ubigeo_description.trim() === '') {
            searchUbigeos.value = [];
            return;
        }

        searchUbigeos.value = props.ubigeo.filter(row =>
            row.district_name.toLowerCase().includes(form.ubigeo_description.toLowerCase())
        );
    }
    const selectCity = (item) => {
        form.ubigeo_description = item.department_name+'-'+item.province_name+'-'+item.district_name;
        form.ubigeo = item.district_id;
        searchUbigeos.value = []; // Limpiar la lista de búsqueda después de seleccionar una ciudad
    }

    const loadFile = (event) => {
        const input = event.target;
        const file = input.files[0];
        const type = file.type;

        // Obtén una referencia al elemento de imagen a través de Vue.js
        const imagePreview = document.getElementById('preview_img');

        // Crea un objeto de archivo de imagen y asigna la URL al formulario
        const imageFile = URL.createObjectURL(event.target.files[0]);
        form.image_view = imageFile;
        // Asigna el archivo a form.image
        form.image = file;
        // Libera la URL del objeto una vez que la imagen se haya cargado
        imagePreview.onload = function() {
            URL.revokeObjectURL(imageFile); // libera memoria
        }
    };
 </script>

<template>
    <FormSection @submitted="createEstablishment">
        <template #title>
            Datos de Tienda
        </template>

        <template #description>
            Crear nueva Tienda
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="description" value="Descripción" />
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="address" value="Dirección" />
                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="phone" value="Teléfono" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="agent" value="Representante " />
                <TextInput
                    id="agent"
                    v-model="form.agent"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.agent" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="email" value="Correo de contacto" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div v-can="'sale_tienda_agregar_vendedor'" class="col-span-6 sm:col-span-3">
                <InputLabel for="user" value="Vendedor" />
                <select v-model="form.user_id" id="stablishment" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Sin Vendedor</option>
                    <template v-for="(user, index) in props.users" :key="index">
                        <option :value="user.id">{{ user.name }}</option>
                    </template>
                </select>
                <InputError :message="form.errors.user_id" class="mt-2" />
            </div>
            <div class="col-span-6 ">
                <InputLabel for="address" value="Ciudad" />
                <div class="relative">
                    <TextInput 
                    v-model="form.ubigeo_description" 
                    @input="filterCities"
                    placeholder="Buscar Distrito"
                    type="text" 
                    class="block w-full mt-1" />
                    <ul v-if="searchUbigeos && searchUbigeos.length > 0" class="list-disc list-inside absolute z-50 w-full bg-white border border-gray-300 rounded-md mt-1">
                        <li v-for="item in searchUbigeos" :key="item.id" class="px-4 cursor-pointer hover:bg-gray-100" @click="selectCity(item)">
                            {{ item.department_name+'-'+item.province_name+'-'+item.district_name }}
                        </li>
                    </ul>
                </div>                
                <div>
                    <InputError :message="form.errors.ubigeo" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 ">
                <InputLabel for="image" value="Imagen *" />
                <div class="flex justify-center space-x-2">
                    <figure class="max-w-lg">
                        <img style="width: 200px;" id="preview_img" class="h-auto rounded-lg" :src="form.image_view">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen Actual</figcaption>
                    </figure>
                </div>

                <input @change="loadFile" accept=".svg, .png, .jpg, .jpeg, .gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG or GIF (RECOMENDADO. 800x400px).</p>
                <InputError :message="form.errors.image" class="mt-2" />
            </div>
            <div class="col-span-6 ">
                <InputLabel for="map" value="Codigo Mapa" />
                <textarea v-model="form.map" id="map" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                <InputError :message="form.errors.map" class="mt-2" />
            </div>
            <div class="col-span-6 " v-html="form.map"></div>
        </template>

        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Guardar
                    </PrimaryButton>
                    <Link :href="route('establishments.index')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
