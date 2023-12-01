<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Keypad from '@/Components/Keypad.vue';
import Swal2 from 'sweetalert2';
import { ref } from 'vue';
import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
    section: {
        type: Object,
        default: () => ({}),
    },
    types: {
        type: Object,
        default: () => ({}),
    },
    groups: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    section_description:  props.section.description,
    description: null,
    section_id: props.section.id,
    contents: [{
        id: null,
        type_id: null,
        description: null,
        position: 0
    }]
});

const createGroupItems = () => {
    form.post(route('cms_section_group_items_store'), {
        errorBag: 'createGroupItems',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se registró correctamente',
                icon: 'success',
            });
            form.description = null;
            form.contents = [{
                type_id: null,
                description: null,
                position: 0
            }];
            router.visit(route('cms_section_group_items',props.section.id), { replace: true, method: 'get' });
        },
    });
}

const addItemInSection = () => {
    let item = {
        type_id: null,
        description: null,
        position: 0
    };
    form.contents.push(item);

}

const arrayGroups = ref([]);

arrayGroups.value = props.groups;

const saveChangeItem = (data,id) => {
    const formData = new FormData();
    var btn = document.getElementById("btn-save-change" + id);
    // Cambiar la opacidad a 25% (0.25)
    btn.style.opacity = "0.25";
    btn.disabled = true;

    var spinner = document.getElementById("spinner-save-change"+ id);

    // Cambiar el estilo para que el elemento sea display: block
    spinner.style.display = "block";

    data.forEach((it, index) => {
        if (it.content instanceof File) {
            formData.append(`items[${index}][is_file]`, 'yes');
        } else if (typeof it.content === 'string') {
            formData.append(`items[${index}][is_file]`, 'no');
        }
        formData.append(`items[${index}][id]`, it.id);
        formData.append(`items[${index}][type_id]`, it.type_id);
        formData.append(`items[${index}][content]`, it.content);
    });

    axios.post(route('cms_pages_section_items_save'), formData).then((res) => {
        Swal2.fire({
            title: 'Enhorabuena',
            text: 'Se registró correctamente',
            icon: 'success',
        });
        btn.style.opacity = "";
        btn.disabled = false;
        spinner.style.display = "none";
    });

}

const destroyGroup = (id) => {
    Swal2.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, Eliminar!',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return axios.delete(route('cms_section_group_items_destroy', id)).then((res) => {
                if (!res.data.success) {
                    Swal2.showValidationMessage(res.data.message)
                }
                return res
            });
        },
        allowOutsideClick: () => !Swal2.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se Eliminó correctamente',
                icon: 'success',
            });
            router.visit(route('cms_section_group_items',props.section.id), { replace: true, method: 'get' });
        }
    });
}

</script>

<template>
    <FormSection @submitted="createGroupItems" class="">
        <template #title>
            Crear Grupo
        </template>

        <template #description>
            Crear nuevo Grupo en el CMS y configurar que items tendra, Los campos con * son obligatorios
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6 ">
                <InputLabel for="description" value="Descripción o Nombre del Grupo*" />
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
                CONTENIDO
            </div>
            <div class="col-span-6 sm:col-span-3 ">
                <button @click="addItemInSection" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
            </div>
            <div class="col-span-6 p-4 border border-stroke">
                <div v-for="(item, ke) in form.contents" class="grid grid-cols-6 gap-6 ">
                    <div class="col-span-6 sm:col-span-2 ">
                        <InputLabel for="type_id" value="Tipo *" />
                        <select v-model="item.type_id" id="type_id" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected>Seleccionar</option>
                            <option v-for="(type) in types" :value="type.id">{{ type.description }}</option>
                        </select>
                        <InputError :message="form.errors[`contents.${ke}.type_id`]" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4 ">
                        <InputLabel for="description" value="Descripción *" />
                        <TextInput
                            id="description"
                            v-model="item.description"
                            type="text"
                            class="block w-full mt-1"
                            autofocus
                        />
                        <InputError :message="form.errors[`contents.${ke}.description`]" class="mt-2" />
                    </div>
                    
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
                    <Link :href="route('cms_section_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>

    
    <div class="grid grid-cols-6 gap-6">
        <div v-for="(gr, groupIndex) in arrayGroups" class="col-span-2 sm:col-span-2">
            <template v-if="gr.group">
                <div class="max-w-sm bg-white p-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-end px-4 pt-4">
                        <button @click="destroyGroup(gr.group.id)" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <font-awesome-icon :icon="faTrashAlt" />
                        </button>
                    </div>
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ gr.group.description }}</h5>
                    <div v-for="(item, itemIndex) in gr.group.items">
                        <template v-if="item.type_id == 1">
                            <InputLabel for="content" :value="item.description" />
                            <div class="flex justify-center space-x-2">
                                <figure class="max-w-lg">
                                    <img class="h-auto max-w-full rounded-lg" :src="item.content">
                                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen Actual</figcaption>
                                </figure>
                            </div>
                            <input @input="item.content = $event.target.files[0]" accept=".svg, .png, .jpg, .jpeg, .gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                        </template>
                        <template v-if="item.type_id == 2">
                            <InputLabel for="content" :value="item.description" />
                            <TextInput
                                id="content"
                                v-model="item.content"
                                type="text"
                                class="block w-full mt-1"
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">AV1, VP9, MP4 (RECOMENDADO. 5-10 MB).</p>
                        </template>
                        <template v-if="item.type_id == 3">
                            <InputLabel for="content" :value="item.description" />
                            <input @input="item.content = $event.target.files[0]" accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOC, PPT o PPTX, XLS o XLSX (RECOMENDADO. 5-10 MB).</p>
                        </template>
                        <template v-if="item.type_id == 4">
                            <InputLabel for="content" :value="item.description" />
                            <textarea v-model="item.content" id="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </template>
                    </div>
                    <button 
                    @click="saveChangeItem(gr.group.items, gr.id)" 
                    :id="'btn-save-change'+ gr.id"
                    type="button" class="mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">
                        <svg style="display: none;" :id="'spinner-save-change'+ gr.id" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </template>
        </div>
    </div>


</template>