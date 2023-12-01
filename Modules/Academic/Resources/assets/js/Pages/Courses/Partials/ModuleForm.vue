<script setup>
import { Timeline, TimelineItem, TimelinePoint, TimelineContent,TimelineTime, TimelineTitle, TimelineBody } from 'flowbite-vue'
import { useForm } from '@inertiajs/vue3';
import { watch, ref, onMounted } from 'vue';
import InputError from '@/Components/InputError.vue';
import Swal2 from 'sweetalert2';
import ThemeContents from './ThemeContents.vue';
import ModalLargeXX from '@/Components/ModalLargeXX.vue';

const props = defineProps({
    display:{
        type: Object,
        default: () => ({})
    },
    faFile:{
        type: Object,
        default: () => ({})
    },
    faPlay:{
        type: Object,
        default: () => ({})
    },
    faDownload:{
        type: Object,
        default: () => ({})
    },
    faCheck:{
        type: Object,
        default: () => ({})
    },
    course:{
        type: Object,
        default: () => ({})
    },
    faTrashAlt:{
        type: Object,
        default: () => ({})
    },
    faSpellCheck:{
        type: Object,
        default: () => ({})
    },
    faFilm:{
        type: Object,
        default: () => ({})
    },
    faXmark:{
        type: Object,
        default: () => ({})
    }
});

const modulesLoading = ref([]);
const themesLoading = ref([]);

const form = useForm({
    course_id : props.course.course_id,
    position: null,
    description: null,
    modules: []
});

const displayModalModules = ref(false);

watch(() => props.course, (data) => {
    form.course_id = data.course_id;
    form.modules = data.modules;
    form.modules.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
    modulesLoading.value = form.modules.map(() => ({ loading: false }));
    formTheme.reset();
    displayModalModules.value = true;
});

const saveModuleNew = () => {
    form.processing = true;
    axios.post(route('aca_courses_module_store'), {
        course_id: form.course_id,
        position: form.position,
        description: form.description
    }).then(response => {
        let module = response.data.module;
        form.clearErrors();
        Swal2.fire({
            title: 'Enhorabuena',
            text: 'Se Actualizó correctamente',
            icon: 'success',
        });
        form.processing = false;
        form.position = null;
        form.description = null;
        form.modules.push(module);
        form.modules.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
        modulesLoading.value = [];
    }).then(()=>{
        modulesLoading.value = form.modules.map(() => ({ loading: false }));
    }).catch(error => {
        let validationErrors = error.response.data.errors;
        if (validationErrors && validationErrors.position) {
            const positionErrors = validationErrors.position;

            for (let i = 0; i < positionErrors.length; i++) {
                form.setError('position', positionErrors[i]);
            }
        }
        if (validationErrors && validationErrors.description) {
            const descriptionErrors = validationErrors.description;

            for (let i = 0; i < descriptionErrors.length; i++) {
                form.setError('description', descriptionErrors[i]);
            }
        }
        form.processing = false;
    });
}
const saveModuleUpdate = (index, module) => {
    modulesLoading.value[index].loading = true;
    axios.put(route('aca_courses_module_update',module.id), {
        position: module.position,
        description: module.description
    }).then(response => {
        form.clearErrors();
        Swal2.fire({
            title: 'Enhorabuena',
            text: 'Se registró correctamente',
            icon: 'success',
        });
        modulesLoading.value[index].loading = false;
        form.modules.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
        modulesLoading.value = form.modules.map(() => ({ loading: false }));
    }).catch(error => {
        let validationErrors = error.response.data.errors;
        if (validationErrors && validationErrors.position) {
            const positionErrors = validationErrors.position;
            for (let i = 0; i < positionErrors.length; i++) {
                form.setError('modules.'+index+'.position', positionErrors[i]);
            }
        }
        if (validationErrors && validationErrors.description) {
            const descriptionErrors = validationErrors.description;

            for (let i = 0; i < descriptionErrors.length; i++) {
                form.setError('modules.'+index+'.description', descriptionErrors[i]);
            }
        }
        modulesLoading.value[index].loading = false;
    });
}

const destroyModule = (index,id) => {
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
            return axios.delete(route('aca_courses_module_destroy', id)).then((res) => {
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
            form.modules.splice(index, 1);
            form.modules.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
            modulesLoading.value = form.modules.map(() => ({ loading: false }));
        }
    });
}

const dataThemes = ref([]);
const loadingThemes = ref(false);

const formTheme = useForm({
    module_id : null,
    position: null,
    description: null,
    themes: []
}); 

const getThemesByModuleId = (id) =>{
    loadingThemes.value = true;
    formTheme.module_id = id;
    axios.get(route('aca_courses_module_themes_list', id)).then((res) => {
        formTheme.themes = res.data.themes;
        themesLoading.value = formTheme.themes.map(() => ({ loading: false }));
    }).then(()=>{
        loadingThemes.value = false;
    });
}

const saveThemeNew = () => {
    formTheme.processing = true;
    axios.post(route('aca_courses_module_themes_store'), {
        module_id: formTheme.module_id,
        position: formTheme.position,
        description: formTheme.description
    }).then(response => {
        let theme = response.data.theme;
        formTheme.clearErrors();
        Swal2.fire({
            title: 'Enhorabuena',
            text: 'Se Actualizó correctamente',
            icon: 'success',
        });
        formTheme.processing = false;
        formTheme.position = null;
        formTheme.description = null;
        formTheme.themes.push(theme);
        themesLoading.value = [];
        formTheme.themes.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
    }).then(()=>{
        themesLoading.value = formTheme.themes.map(() => ({ loading: false }));
    }).catch(error => {
        let validationErrors = error.response.data.errors;
        if (validationErrors && validationErrors.position) {
            const positionErrors = validationErrors.position;

            for (let i = 0; i < positionErrors.length; i++) {
                formTheme.setError('position', positionErrors[i]);
            }
        }
        if (validationErrors && validationErrors.description) {
            const descriptionErrors = validationErrors.description;

            for (let i = 0; i < descriptionErrors.length; i++) {
                formTheme.setError('description', descriptionErrors[i]);
            }
        }
        formTheme.processing = false;
    });
}

const saveThemeUpdate = (index, theme) => {
    themesLoading.value[index].loading = true;
    axios.put(route('aca_courses_module_themes_update',theme.id), {
        position: theme.position,
        description: theme.description
    }).then(response => {
        form.clearErrors();
        Swal2.fire({
            title: 'Enhorabuena',
            text: 'Se registró correctamente',
            icon: 'success',
        });
        themesLoading.value[index].loading = false;
        formTheme.themes.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
        
    }).then(() => {
        themesLoading.value = formTheme.themes.map(() => ({ loading: false }));
    }).catch(error => {
        let validationErrors = error.response.data.errors;
        if (validationErrors && validationErrors.position) {
            const positionErrors = validationErrors.position;
            for (let i = 0; i < positionErrors.length; i++) {
                formTheme.setError('themes.'+index+'.position', positionErrors[i]);
            }
        }
        if (validationErrors && validationErrors.description) {
            const descriptionErrors = validationErrors.description;

            for (let i = 0; i < descriptionErrors.length; i++) {
                formTheme.setError('themes.'+index+'.description', descriptionErrors[i]);
            }
        }
        themesLoading.value[index].loading = false;
    });
}

const destroyTheme = (index,id) => {
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
            return axios.delete(route('aca_courses_module_themes_destroy', id)).then((res) => {
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
            formTheme.themes.splice(index, 1);
            formTheme.themes.sort((a, b) => parseInt(a.position, 10) - parseInt(b.position, 10));
        }
    }).then(() => {
        themesLoading.value = formTheme.themes.map(() => ({ loading: false }));
    });
}

//////////contenido de las clases///////////
const dataModalContent = ref([]) ;

const getContentByThemeId = (theme) => {
    dataModalContent.value = {
        theme_id: theme.id,
        theme_name: theme.description,
        contents: theme.contents
    };
}

const closeModalModules = () =>{
    displayModalModules.value = false;
}
</script>
<template>
    <ModalLargeXX
        :onClose="closeModalModules"
        :show="displayModalModules"
        :icon="'/img/carpeta.png'"
    >
            <template #title>
                Modulos
            </template>
            <template #message>
                {{ course.name_course }}
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3" >
                        <div class="px-2">
                            <ol class="space-y-4 w-full" >
                                <li class="mb-2">
                                    <div class="w-full p-2 text-green-700 border border-green-300 rounded-lg bg-green-200 dark:bg-gray-800 dark:border-green-800 dark:text-green-400" >
                                        <div class="flex items-center">   
                                            <label for="simple-module" class="sr-only">Modulo</label>
                                            <div class="relative w-20 mr-1">
                                                <input v-model="form.position" type="text" id="simple-module" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Posición" required>
                                            </div>
                                            <div class="relative w-full">
                                                <input v-model="form.description" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del Modulo" required>
                                            </div>
                                            <button @click="saveModuleNew" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="button" class="ml-1 inline-flex items-center px-3 py-2.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <svg v-if="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                </svg>
                                                <font-awesome-icon v-else :icon="faCheck" />
                                            </button>
                                        </div>
                                        <InputError :message="form.errors.position" class="mt-2" />
                                        <InputError :message="form.errors.description" class="mt-2" />
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div style="max-height: 350px; overflow-y: auto;" class="px-2">
                            <Timeline>
                                <TimelineItem v-for="(module, index) in form.modules" class="mb-2">
                                    <TimelinePoint />
                                    <TimelineContent>
                                        <TimelineTitle>
                                            <div class="flex items-center">   
                                                <label :for="'position'+index" class="sr-only">Modulo</label>
                                                <div class="relative w-20 mr-1">
                                                    <input v-model="module.position" type="text" :id="'position'+index" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Posición" required>
                                                </div>
                                                <div class="relative w-full">
                                                    <input v-model="module.description"  type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del Modulo" required>
                                                </div>
                                                <template v-if="modulesLoading.length > 0">
                                                    <button @click="saveModuleUpdate(index,module)" :class="{ 'opacity-25': modulesLoading[index].loading }" :disabled="modulesLoading[index].loading" type="button" title="Actualizar"  class="ml-1 inline-flex items-center px-3 py-2.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                        <svg v-if="modulesLoading[index].loading" aria-hidden="true" role="status" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                        </svg>
                                                        <font-awesome-icon v-else :icon="faCheck" />
                                                    </button>
                                                </template>
                                                <button @click="destroyModule(index,module.id)" type="button" title="Eliminar"  class="ml-1 inline-flex items-center px-3 py-2.5 bg-red-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    <font-awesome-icon :icon="faTrashAlt" />
                                                </button>
                                                <button @click="getThemesByModuleId(module.id)" type="button" title="Clases" class="ml-1 inline-flex items-center px-2.5 py-2.5 bg-green-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-800 dark:hover:bg-white focus:bg-gray-800 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    <font-awesome-icon :icon="faSpellCheck" />
                                                </button>
                                            </div>
                                            <InputError :message="form.errors[`modules.${index}.position`]" class="mt-2" />
                                            <InputError :message="form.errors[`modules.${index}.description`]" class="mt-2" />
                                        </TimelineTitle>
                                    </TimelineContent>
                                </TimelineItem>
                            </Timeline>
                        </div>
                    </div>
                    <div v-if="formTheme.module_id" class="col-span-6 sm:col-span-3" >
                        <div class="px-2">
                            <ol class="space-y-4 w-full" >
                                <li class="mb-2">
                                    <div class="w-full p-2 text-green-700 border border-green-300 rounded-lg bg-green-200 dark:bg-gray-800 dark:border-green-800 dark:text-green-400" >
                                        <div class="flex items-center">   
                                            <label for="simple-module" class="sr-only">thema</label>
                                            <div class="relative w-20 mr-1">
                                                <input v-model="formTheme.position" type="text" id="simple-module" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Posición" required>
                                            </div>
                                            <div class="relative w-full">
                                                <input v-model="formTheme.description" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del Modulo" required>
                                            </div>
                                            <button @click="saveThemeNew" :class="{ 'opacity-25': formTheme.processing }" :disabled="formTheme.processing" type="button" class="ml-1 inline-flex items-center px-3 py-2.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <svg v-if="formTheme.processing" aria-hidden="true" role="status" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                </svg>
                                                <font-awesome-icon v-else :icon="faCheck" />
                                            </button>
                                        </div>
                                        <InputError :message="formTheme.errors.position" class="mt-2" />
                                        <InputError :message="formTheme.errors.description" class="mt-2" />
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div style="max-height: 350px; overflow-y: auto;" class="px-2">
                            <div v-if="loadingThemes" class="flex items-center justify-center w-56 h-56 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <Timeline v-else>
                                <TimelineItem v-for="(theme, key) in formTheme.themes" class="mb-2">
                                    <TimelinePoint />
                                    <TimelineContent>
                                        <TimelineTitle>
                                            <div class="flex items-center">   
                                                <label :for="'theme-titble'+key" class="sr-only">title</label>
                                                <div class="relative w-20 mr-1">
                                                    <input v-model="theme.position" type="text" :id="'theme-titble'+key" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                                </div>
                                                <div class="relative w-full">
                                                    <input v-model="theme.description" type="text" :id="'theme-titble'+key" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                                </div>
                                                <template v-if="themesLoading.length > 0">
                                                    <button @click="saveThemeUpdate(key, theme)" type="button" title="Actualizar"  class="ml-1 inline-flex items-center px-3 py-2.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                        <svg v-if="themesLoading[key].loading" aria-hidden="true" role="status" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                        </svg>
                                                        <font-awesome-icon v-else :icon="faCheck" />
                                                    </button>
                                                </template>
                                                <button @click="destroyTheme(key,theme.id)" type="button" title="Eliminar"  class="ml-1 inline-flex items-center px-3 py-2.5 bg-red-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    <font-awesome-icon :icon="faTrashAlt" />
                                                </button>
                                                <button @click="getContentByThemeId(theme)" type="button" title="Contenido" class="ml-1 inline-flex items-center px-2.5 py-2.5 bg-green-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-800 dark:hover:bg-white focus:bg-gray-800 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    <font-awesome-icon :icon="faSpellCheck" />
                                                </button>
                                            </div>
                                        </TimelineTitle>
                                    </TimelineContent>
                                </TimelineItem>
                            </Timeline>
                        </div>
                    </div>
                </div>
        </template>
    </ModalLargeXX>

    <ThemeContents
        :faXmark="faXmark" 
        :faCheck="faCheck"
        :faTrashAlt="faTrashAlt"
        :faFilm="faFilm"
        :faPlay="faPlay"
        :faDownload="faDownload"
        :faFile="faFile"
        :theme="dataModalContent" 
    />
</template>