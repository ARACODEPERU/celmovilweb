<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Keypad from '@/Components/Keypad.vue';
import Swal2 from 'sweetalert2';
import { ref, watch, onMounted } from 'vue';
import { Select, TreeSelect } from 'ant-design-vue';
import 'cropperjs/dist/cropper.css';
import CropperImage from '@/Components/CropperImage.vue';

const props = defineProps({
    ubigeo: {
        type: Object,
        default: () => ({}),
    },
    local: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    id: props.local.id,
    names: props.local.names,
    address: props.local.address,
    map_code: props.local.map_code,
    image1: props.local.image1,
    image2: props.local.image2,
    image3: props.local.image3,
    image4: props.local.image4,
    maximum_capacity: props.local.maximum_capacity,
    status: props.local.status == 1 ? true : false,
    ubigeo: props.local.ubigeo,
    ubigeo_description: null
});

onMounted(() => {
    if(form.ubigeo){
        const ubigeo = props.ubigeo.find(row => row.district_id.toLowerCase() === form.ubigeo.toLowerCase());
        form.ubigeo_description = ubigeo ? ubigeo.department_name+'-'+ubigeo.province_name+'-'+ubigeo.district_name : '';
    }
})

const updateNow = () => {
    form.post(route('even_local_update'), {
        forceFormData: true,
        errorBag: 'updateNow',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se Actualizado correctamente',
                icon: 'success',
            });
        },
    });
}

const cropImageAndSave = (res) => {
    form.image1 = res;
}

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

</script>

<template>
    <FormSection @submitted="updateNow" class="">
        <template #title>
            Categoría Detalles
        </template>

        <template #description>
            Crear nueva Categoría, Los campos con * son obligatorios
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel for="names" value="Nombre *" class="mb-1" />
                <TextInput
                    id="names"
                    v-model="form.names"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.names" class="mt-2" />
            </div>
            <div class="col-span-6">
                <InputLabel for="address" value="Dirección *" class="mb-1" />
                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.address" class="mt-2" />
            </div>
            <div class="col-span-6">
                <InputLabel for="map_code" value="Codigo del Mapa *" class="mb-1" />
                <textarea v-model="form.map_code" id="map_code" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                <InputError :message="form.errors.map_code" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
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
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="maximum_capacity" value="Capacidad máxima *" class="mb-1" />
                <TextInput
                    id="maximum_capacity"
                    v-model="form.maximum_capacity"
                    type="text"
                    class="w-full mt-1"
                    
                />
                <InputError :message="form.errors.maximum_capacity" class="mt-2" />
            </div>
            <div class="col-span-6">
                <InputLabel for="file_input" value="Imagen *" />
                <CropperImage
                    ref="cropper"
                    @onCrop="cropImageAndSave"
                ></CropperImage>
                <InputError :message="form.errors.image1" class="mt-2" />
            </div>
            
            <div class="col-span-6">
                <div class="flex items-center">
                    <input id="checked-checkbox-2" type="checkbox" v-model="form.status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checked-checkbox-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Activo</label>
                </div>
            </div>
        </template>

        <template #actions>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="mr-2">
                {{ form.progress.percentage }}%
            </progress>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Actualizar
                    </PrimaryButton>
                    <Link :href="route('even_local_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>