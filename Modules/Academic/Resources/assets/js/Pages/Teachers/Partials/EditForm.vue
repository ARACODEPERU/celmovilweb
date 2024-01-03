<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Keypad from '@/Components/Keypad.vue';
import Swal2 from 'sweetalert2';
import { ref, watch } from 'vue';

const props = defineProps({
    identityDocumentTypes: {
        type: Object,
        default: () => ({}),
    },
    ubigeo: {
        type: Object,
        default: () => ({})
    },
    teacher: {
        type: Object,
        default: () => ({})
    }
});


const form = useForm({
    id: props.teacher.id,
    teacher_id: props.teacher.teacher_id,
    document_type_id: props.teacher.document_type_id,
    number: props.teacher.number,
    telephone: props.teacher.telephone,
    email: props.teacher.email,
    image: null,
    image_preview: props.teacher.image_preview,
    address: props.teacher.address,
    ubigeo: props.teacher.ubigeo,
    birthdate: props.teacher.birthdate,
    names: props.teacher.names,
    father_lastname: props.teacher.father_lastname,
    mother_lastname: props.teacher.mother_lastname,
    ubigeo_description: props.teacher.city,
    presentacion: props.teacher.presentacion
});

const createPatient = () => {
    form.post(route('aca_teachers_update'), {
        forceFormData: true,
        errorBag: 'createPatient',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se Actualizó correctamente',
                icon: 'success',
            });
        },
    });
}

const searchUbigeos = ref([]);

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
    form.image_preview = imageFile;
    // Asigna el archivo a form.image
    form.image = file;
    // Libera la URL del objeto una vez que la imagen se haya cargado
    imagePreview.onload = function() {
        URL.revokeObjectURL(imageFile); // libera memoria
    }
};
</script>

<template>
    <FormSection @submitted="createPatient" class="">
        <template #title>
            Docente Detalles
        </template>

        <template #description>
            Crear nuevo Docente, Los campos con * son obligatorios
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-2 ">
                <InputLabel for="document_type_id" value="Tipo *" />
                <select v-model="form.document_type_id" id="document_type_id" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>Seleccionar</option>
                    <option v-for="(identityDocumentType) in identityDocumentTypes" :value="identityDocumentType.id">{{ identityDocumentType.description }}</option>
                </select>
                <InputError :message="form.errors.document_type_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2 ">
                <InputLabel for="number" value="Número *" />
                <TextInput
                    id="number"
                    v-model="form.number"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.number" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2 ">
                <InputLabel for="birthdate" value="Fecha de nacimiento *" />
                <TextInput
                    id="birthdate"
                    v-model="form.birthdate"
                    type="date"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.birthdate" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6 ">
                <div class="flex items-center space-x-6">
                    <div v-show="form.image_preview" class="shrink-0">
                        <img id='preview_img' class="h-16 w-16 object-cover rounded-full" :src="form.image_preview" alt="Current profile photo" />
                    </div>
                    <label class="block ml-1">
                        <span class="sr-only">Elige foto</span>
                        <input @change="loadFile" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                    </label>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="names" value="Nombres *" />
                <TextInput
                    id="names"
                    v-model="form.names"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.names" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="father_lastname" value="Apellido Paterno *" />
                <TextInput
                    id="father_lastname"
                    v-model="form.father_lastname"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.father_lastname" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="mother_lastname" value="Apellido Materno *" />
                <TextInput
                    id="mother_lastname"
                    v-model="form.mother_lastname"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.mother_lastname" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="address" value="Dirección *" />
                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6 ">
                <InputLabel for="ubigeo" value="Ciudad *" />
                <div class="relative">
                    <TextInput 
                    v-model="form.ubigeo_description" 
                    @input="filterCities"
                    placeholder="Buscar Distrito"
                    type="text" 
                    class="block w-full mt-1" />
                    <ul v-if="searchUbigeos && searchUbigeos.length > 0" style="max-height: 200px; overflow-y: auto;" class="list-disc list-inside absolute z-50 w-full bg-white border border-gray-300 rounded-md mt-1">
                        <li v-for="item in searchUbigeos" :key="item.id" class="px-4 cursor-pointer hover:bg-gray-100" @click="selectCity(item)">
                            {{ item.department_name+'-'+item.province_name+'-'+item.district_name }}
                        </li>
                    </ul>
                </div>
                <InputError :message="form.errors.ubigeo" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <InputLabel for="telephone" value="Teléfono *" />
                <TextInput
                    id="telephone"
                    v-model="form.telephone"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.telephone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="email" value="Email *" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6">
                <InputLabel for="presentacion" value="Presentación *" />
                <textarea
                    id="presentacion"
                    v-model="form.presentacion"
                    rows="4" 
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                </textarea>
                <InputError :message="form.errors.presentacion" class="mt-2" />
            </div>
        </template>

        <template #actions>
            
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Actualizar
                    </PrimaryButton>
                    <Link :href="route('aca_teachers_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>