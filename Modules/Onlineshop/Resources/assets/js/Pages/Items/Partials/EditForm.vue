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
import Editor from '@tinymce/tinymce-vue'
import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
    item: {
        type: Object,
        default: () => ({}),
    },
    type: {
        type: String,
        default: () => ({}),
    },
    tiny_api_key: {
        type: String,
        default: () => ({}),
    }
});

const titles = ref({
    additional: props.type == 1 ? 'Tipo' : 'Recomendación',
    additional1: props.type == 1 ? 'Modalidad' : 'Video',
    additional2: props.type == 3 ? 'Ficha técnica' : 'Brochure',
    additional3: props.type == 3 ? 'Manual' : null,
    additional4: props.type == 3 ? 'Legal' : null,
    additional5: props.type == 3 ? 'Tipo' : null,
});

const form = useForm({
    id: props.item.id,
    type: props.type,
    category_description: props.item.category_description,
    name: props.item.name,
    description: props.item.description,
    price: props.item.price,
    discount: props.item.discount,
    image: null,
    image_view: props.item.image,
    status: props.item.status == 1 ? true : false,
    additional: props.item.additional,
    additional1: props.item.additional1,
    additional2: props.item.additional2,
    additional3: props.item.additional3,
    additional4: props.item.additional4,
    additional5: props.item.additional5,
    countCharacters: props.item.description.length,
    specifications: []
});

if(props.item.specifications.length > 0){
    props.item.specifications.forEach(objeto => {
        form.specifications.push({
            title: objeto.title,
            description: objeto.description
        });
    });
}


watch(() => form.description, (newValue) => {
    form.countCharacters = newValue.length;
});

const updateItem = () => {
    form.post(route('onlineshop_items_update'), {
        errorBag: 'updateItem',
        forceFormData: true,
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

const handleFileChange = (event) => {
    try {
        form.additional2 = event.target.files[0];
    } catch (error) {
        console.error("Error al manejar el cambio de archivo:", error);
    }
}

const addSpecifications = () => {
    form.specifications.push({
        title: null,
        description: null
    });
}

const removeSpecifications= (key) => {
    form.specifications.splice(key, 1);
}

</script>

<template>
    <FormSection @submitted="updateItem" class="">
        <template #title>
            Items Detalles
        </template>

        <template #description>
            Crear Editar Items, Los campos con * son obligatorios
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6 ">
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="off"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            
            <div v-if="form.type == 1" class="col-span-6 sm:col-span-6 ">
                <InputLabel for="description" value="Descripción" />
                <textarea v-model="form.description" id="description" rows="2" autofocus class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe descripción aquí..."></textarea>
                <span id="charCount">{{ form.countCharacters }}</span> caracteres de máximo 255
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div v-if="form.type == 2 || form.type == 3" class="col-span-6 sm:col-span-6 ">
                <InputLabel for="description" value="Descripción" />
                <Editor
                    id="description"
                    :api-key="tiny_api_key"
                    v-model="form.description"
                    :init="{
                        plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
                        language: 'es',
                    }"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div v-if="form.type == 1" class="col-span-6 sm:col-span-6">
                <InputLabel for="category_description" value="Sector" />
                <select id="category_description" v-model="form.category_description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Seleccionar Sector</option>
                    <option value="Derecho">Derecho</option>
                    <option value="Empresarial">Empresarial</option>
                    <option value="Publico">Público</option>
                    <!-- Agrega más opciones según tus necesidades -->
                </select>
                <InputError :message="form.errors.category_description" class="mt-2" />
            </div>
            <div v-else class="col-span-6 sm:col-span-6">
                <InputLabel for="category_description" value="Sector" />                       
                <TextInput
                    id="category_description"
                    v-model="form.category_description"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="off"
                />
                <InputError :message="form.errors.category_description" class="mt-2" />
            </div>

            <div v-if="form.type == 1"  class="col-span-6 sm:col-span-6">
                <InputLabel for="additional1" :value="titles.additional1+'*'" />
                <select id="additional1" v-model="form.additional1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Seleccionar modalidad</option>
                    <option value="En Vivo">En Vivo</option>
                    <option value="Presencial">Presencial</option>
                    <option value="E-Learning">E-Learning</option>
                    <!-- Agrega más opciones según tus necesidades -->
                </select>
                <InputError :message="form.errors.additional1" class="mt-2" />
            </div>

            <div v-if="form.type == 2 || form.type == 3" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional1" :value="titles.additional1+'*'" />
                <textarea v-model="form.additional1" id="additional1" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                <InputError :message="form.errors.additional1" class="mt-2" />
            </div>

            <div v-if="form.type == 1" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional" value="Tipo*" />
                <select id="additional" v-model="form.additional" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Seleccionar tipo</option>
                    <option value="Curso">Curso</option>
                    <option value="Diplomado">Diplomado</option>
                </select>
                <InputError :message="form.errors.additional" class="mt-2" />
            </div>
           
            <div v-if="form.type == 2 || form.type == 3" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional" :value="titles.additional+'*'" />
                <Editor
                    id="additional"
                    :api-key="tiny_api_key"
                    v-model="form.additional"
                    :init="{
                        plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
                        language: 'es',
                    }"
                />
                <InputError :message="form.errors.additional" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-6">
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

            <!-- agregado para celmovil -->
            <div v-if="form.type == 3" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional2" :value="titles.additional2+'*'" />
                <input @change="handleFileChange" accept=".pdf, image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                <InputError :message="form.errors.additional2" class="mt-2" />
            </div>

            <div v-if="form.type == 3" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional3" :value="titles.additional3+'*'" />
                <input v-model="form.additional3" type="text" id="additional3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="link manual" required>
                <InputError :message="form.errors.additional3" class="mt-2" />
            </div>
            <div v-if="form.type == 3" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional4" :value="titles.additional4+'*'" />
                <Editor
                    id="additional4"
                    :api-key="tiny_api_key"
                    v-model="form.additional4"
                    :init="{
                        plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
                        language: 'es',
                    }"
                />
                <InputError :message="form.errors.additional4" class="mt-2" />
            </div>
            <div v-if="form.type == 3" class="col-span-6 sm:col-span-6">
                <InputLabel for="additional5" :value="titles.additional5+'*'" />
                <select v-model="form.additional5" id="additional5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="NO">Venta Normal</option>
                    <option value="PR">En Promoción</option>
                    <option value="DE">Con Descuento</option>
                </select>
                <InputError :message="form.errors.additional5" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="price" value="Precio" />
                <TextInput
                    id="price"
                    v-model="form.price"
                    type="number"
                    class="block w-full mt-1"
                    autocomplete="off"
                />
                <InputError :message="form.errors.price" class="mt-2" />
            </div>
            <div v-if="form.type == 3 && form.additional5 == 'DE'" class="col-span-6 sm:col-span-3">
                <InputLabel for="discount" value="Descuento" />
                <TextInput
                    id="discount"
                    v-model="form.discount"
                    type="number"
                    class="block w-full mt-1"
                    autocomplete="off"
                />
                <InputError :message="form.errors.discount" class="mt-2" />
            </div>
            <div v-if="form.type == 3"  class="col-span-6" >
                <div class="relative overflow-x-auto border">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr class="px-6 py-3 bg-gray-200 dark:bg-gray-800">
                                <th colspan="3" scope="col" class="px-6 py-3">
                                    <div class="flex items-center justify-between">
                                        <span>ESPECIFICACIONES DEL PRODUCTO</span> 
                                        <button @click="addSpecifications" type="button" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Agregar
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(del, ky) in form.specifications" class="border-b border-gray-50 dark:border-gray-700">
                                <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-100 dark:text-white dark:bg-gray-800">
                                    <input v-model="del.title" type="text" :id="'input-title'+ky" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </th>
                                <td class="px-2 py-4">
                                    <input v-model="del.description" type="text" :id="'input-description'+ky" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </td>
                                <td class="px-2 py-4">
                                    <button @click="removeSpecifications(ky)" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        <font-awesome-icon :icon="faTrashAlt" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="flex items-center mb-4">
                    <input v-model="form.status" id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Activo</label>
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
                    <Link :href="route('onlineshop_items')" class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>