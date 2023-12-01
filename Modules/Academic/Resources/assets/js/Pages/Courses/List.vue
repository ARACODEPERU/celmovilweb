<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Keypad from '@/Components/Keypad.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { Dropdown } from 'flowbite-vue'
    import Swal2 from "sweetalert2";
    import { Link, router, useForm } from '@inertiajs/vue3';
    import { faXmark, faGears, faTrashAlt, faCheck, faSpellCheck, faDownload, faPlay, faFile, faFilm } from "@fortawesome/free-solid-svg-icons";
    import ModalLarge from '@/Components/ModalLarge.vue';
    import { ref } from 'vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import InputError from '@/Components/InputError.vue';
    
    import ModuleForm from './Partials/ModuleForm.vue';

    const props = defineProps({
        courses: {
            type: Object,
            default: () => ({}),
        },
        institutions: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
    });

    const form = useForm({
        search: props.filters.search,
    });

    const destroyCourse = (id) => {
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
                return axios.delete(route('aca_courses_destroy', id)).then((res) => {
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
                router.visit(route('aca_courses_list'), { replace: true, method: 'get' });
            }
        });
    }

    const destroyAgreement = (id) => {
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
                return axios.delete(route('aca_agreements_destroy', id)).then((res) => {
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
                getAgreements(formAgreement.course_id);
            }
        });
    }

    const formAgreement = useForm({
        course_id: null,
        course_name: null,
        institution_id: null,
        start_date: null,
        end_date: null,
        status: null,
        details:[]
    });

    const displayModalAgreements = ref(false);
    const arrayAgreements = ref([]);

    const openModalAgreements = (course) => {
        formAgreement.course_id = course.id;
        formAgreement.course_name = course.description;

        getAgreements(course.id);

        displayModalAgreements.value = true;
    }

    const closeModalAgreements = () => {
        displayModalAgreements.value = false;
        formAgreement.reset();
    }

    const saveAgreements = () => {
        formAgreement.progress = true;
        axios.post(route('aca_agreements_store'), formAgreement ).then((res) => {
            
            formAgreement.progress = false;
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se registró correctamente',
                icon: 'success',
            });
            getAgreements(formAgreement.course_id);
            formAgreement.reset('institution_id', 'start_date','end_date')
            formAgreement.clearErrors();
        }).catch(function (error) {
            if (error.response.status === 422) {
                // Obtén los errores del objeto de respuesta JSON
                const errors = error.response.data.errors;

                for (let field in errors) {
                    formAgreement.setError(field, errors[field][0]);
                }
                
            }
            formAgreement.progress = false;
        });
    }

    const getAgreements = (id) => {
        axios.get(route('aca_agreements_list', id) ).then((res) => {
            arrayAgreements.value = res.data.agreements;
        });
    }

const dataModule = ref({});

const openModalModules = (course) =>{
    dataModule.value = {
        course_id: course.id,
        name_course: course.description,
        modules: course.modules
    };
}

</script>

<template>
    <AppLayout title="Cursos">
        <div class="max-w-screen-2xl  mx-auto p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <nav class="flex px-4 py-3 border border-stroke text-gray-700 mb-4 bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <Link :href="route('dashboard')" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Inicio
                        </Link>
                    </li>
                    <li>
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <!-- <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Productos</a> -->
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Académico</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Cursos</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form id="form-search-items" @submit.prevent="form.get(route('cms_items_list'))">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <input v-model="form.search" type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por Descripción">
                                    </div>
                                </form>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <Keypad>
                                    <template #botones>
                                        <Link v-can="'aca_cursos_nuevo'" :href="route('aca_courses_create')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                            Nuevo
                                        </Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full">
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th  class="py-2 px-4 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Nombre
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Sector
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Tipo
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Modalidad
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(course, index) in courses.data" :key="course.id">
                                    <tr class="border-b border-stroke">
                                        <td class="relative text-center py-2 dark:border-strokedark">
                                            <Dropdown text="Top">
                                                <template #trigger="{ toggle }">
                                                    <button class="border py-1.5 px-2 dropdown-button inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm" type="button" @click="toggle">
                                                        <font-awesome-icon :icon="faGears" />
                                                    </button>
                                                </template>
                                                <div class="dropdown-div z-9999 absolute text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                        <li>
                                                            <Link :href="route('aca_courses_edit',course.id)" class="text-left block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editar</Link>
                                                        </li>
                                                        <li>
                                                            <Link :href="route('aca_courses_information',course.id)" class="text-left block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Información</Link>
                                                        </li>
                                                        <li>
                                                            <a @click="openModalAgreements(course)" href="#" class="text-left block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Convenios</a>
                                                        </li>
                                                        <li>
                                                            <a @click="openModalModules(course)" href="#" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Módulos</a>
                                                        </li>
                                                    </ul>
                                                    <div class="py-2">
                                                        <a @click="destroyCourse(course.id)" href="#" class="text-left block px-4 py-2 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Eliminar</a>
                                                    </div>
                                                </div>
                                            </Dropdown>
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ course.description }}
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ course.category.description }}
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ course.type_description }}
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            <template v-if="course.modality">
                                                {{ course.modality.description }}
                                            </template>
                                        </td>
                                        <td class="text-center py-2 px-2 dark:border-strokedark">
                                            <span v-if="course.status" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Activo</span>
                                            <span v-else class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Inactivo</span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="courses" />
                </div>
            </div>
        </div>
        <ModalLarge
            :onClose = "closeModalAgreements"
            :show="displayModalAgreements"
            :icon="'/img/convenio.png'"
        >
            <template #title>
                Convenio
            </template>
            <template #message>{{ formAgreement.course_name }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-2">
                        <label for="institution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">institución</label>
                        <select v-model="formAgreement.institution_id" id="institution" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option v-for="(institution) in institutions" :value="institution.id">{{ institution.name }}</option>
                        </select>
                        <InputError :message="formAgreement.errors.institution_id" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="star_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Incio</label>
                        <input v-model="formAgreement.start_date" type="date" id="star_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
                        <InputError :message="formAgreement.errors.start_date" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Termino</label>
                        <input v-model="formAgreement.end_date" type="date" id="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
                        <InputError :message="formAgreement.errors.end_date" class="mt-2" />
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="border p-4" v-for="(xagreement) in arrayAgreements">
                            <div class="flex justify-end">
                                <button @click="destroyAgreement(xagreement.id)" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <font-awesome-icon :icon="faTrashAlt" />
                                </button>
                            </div>
                            <img class="h-auto max-w-full rounded-lg" :src="xagreement.institution.image" :alt="xagreement.institution.name">
                        </div>
                    </div>
                </div>
            </template>
            <template #buttons>
                <progress v-if="formAgreement.progress" :value="formAgreement.progress.percentage" max="100" class="mr-2">
                    {{ formAgreement.progress.percentage }}%
                </progress>
                <DangerButton
                    :class="{ 'opacity-25': formAgreement.processing }" :disabled="formAgreement.processing"
                    class="mr-3"
                    @click="saveAgreements()"
                >
                Guardar
            </DangerButton>
            </template>
        </ModalLarge>
        <ModuleForm 
            :faXmark="faXmark"
            :faFilm="faFilm"
            :faFile="faFile"
            :faPlay="faPlay"
            :faDownload="faDownload"
            :faSpellCheck="faSpellCheck" 
            :faCheck="faCheck" 
            :faTrashAlt="faTrashAlt" 
            :course="dataModule" 
        />
    </AppLayout>
</template>
