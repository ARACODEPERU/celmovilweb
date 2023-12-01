<script setup>
    import { useForm } from "@inertiajs/vue3"
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { faTrashAlt, faPencilAlt } from "@fortawesome/free-solid-svg-icons";
    import Keypad from '@/Components/Keypad.vue';
    //import swal from "sweetalert";
    import * as XLSX from 'xlsx/dist/xlsx.full.min';
    //import jsPDF from 'jspdf';

    const props = defineProps({
        subscribers: {
            type: Object,
            default: () => ({})
        },
        filters: {
            type: Object,
            default: () => ({})
        }
    });

    const form = useForm({
        search: props.filters.search,
    });

    function downloadExcel(){
    const workbook = XLSX.utils.book_new();

    // Obtén la tabla HTML que deseas convertir
    const table = document.getElementById('table_export');

    // Convierte la tabla HTML en una hoja de cálculo
    const worksheet = XLSX.utils.table_to_sheet(table);
    worksheet['!cols'] = [
        {width:12}, // Columna "A" Fecha
        { width: 25 }, // Columna "B" Nombres
        {width:25}, // Columna "C" Correos
        { width: 15 }, // Columna "D" Teléfonos
        {width: 40}, //Mensajes
        {width:9}, // Columna "F" 
        {width:9}, // Columna "G" 
        {width:9}, // Columna "H" 
        {width:9}, // Columna "I" 
    ];

    XLSX.utils.book_append_sheet(workbook, worksheet, form.start+'-'+form.end);
    XLSX.writeFile(workbook, 'Suscriptores'+'.xlsx');
}

</script>

<template>
    <AppLayout title="Blog Suscriptores">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="col-span-6 p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
                        <form @submit.prevent="form.get(route('blog_subscriber'))">
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input v-model="form.search" type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por descripción">
                            </div>
                        </form>
                        <div class="text-right">
                            <Keypad>
                                <template #botones>     
                                    <button v-on:click="downloadExcel()"
                                    class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                     >Exportar en Excel
                                    </button>
                                </template>
                            </Keypad>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table id="table_export" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-gray-700 uppercase bg-gray-100 dark:text-gray-400">
                                <tr class="border">
                                    <!-- <th scope="col" class="px-6 py-4 border">
                                        Acciones
                                    </th> -->
                                    <th scope="col" class="px-6 py-4">
                                        <div class="flex items-center">
                                            Fecha
                                            <a href="">
                                                <img style="max-width: 12px;height: auto;" class="svg-img" src="/icons-svg/clasificar.svg" alt="Descripción de la imagen">
                                            </a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        <div class="flex items-center">
                                            Nombres
                                            <a href="">
                                                <img style="max-width: 12px;height: auto;" class="svg-img" src="/icons-svg/clasificar.svg" alt="Descripción de la imagen">
                                            </a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        <div class="flex items-center">
                                            Correo
                                            <a href="">
                                                <img style="max-width: 12px;height: auto;" class="svg-img" src="/icons-svg/clasificar.svg" alt="Descripción de la imagen">
                                            </a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        <div class="flex items-center">
                                            Teléfono
                                            <a href="">
                                                <img style="max-width: 12px;height: auto;" class="svg-img" src="/icons-svg/clasificar.svg" alt="Descripción de la imagen">
                                            </a>
                                        </div>
                                    </th>
                                     <!-- <th scope="col" class="px-6 py-4">
                                        <div class="flex items-center">
                                            Asunto de mensaje
                                            <a href="">
                                                <img style="max-width: 12px;height: auto;" class="svg-img" src="/icons-svg/clasificar.svg" alt="Descripción de la imagen">
                                            </a>
                                        </div>
                                    </th> -->
                                    <th scope="col" class="px-6 py-4">
                                        <div class="flex items-center">
                                            Mensaje
                                            <a href="">
                                                <img style="max-width: 12px;height: auto;" class="svg-img" src="/icons-svg/clasificar.svg" alt="Descripción de la imagen">
                                            </a>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(subscriber, index) in subscribers.data" :key="subscriber.id" class="bg-white border dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <!-- <td class="border px-6 py-4">
                                        <a ref="" class="mr-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <font-awesome-icon :icon="faPencilAlt" />
                                        </a>
                                     
                                    </td> -->
                                    <td class="border px-6 py-4">
                                        {{ formatDateTime(subscriber.created_at) }}
                                    </td>
                                    <td class="border px-6 py-4">
                                        {{ subscriber.full_name }}
                                    </td>
                                    <td class="border px-6 py-4">
                                        {{ subscriber.email }}
                                    </td>
                                    <td class="border px-6 py-4">
                                        {{ subscriber.phone }}
                                    </td>
                                    <!-- <td class="border px-6 py-4">
                                         {{ subscriber.subject }}
                                    </td> -->
                                    <td class="border px-6 py-4">
                                        {{ subscriber.message }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :data="subscribers" />
                </div>

            </div>
        </div>
    </AppLayout>
</template>
<script>
function formatDateTime(dateTimeString) {
  const date = new Date(dateTimeString);
  const formattedDate = date.toISOString().slice(0, 10);
  const formattedTime = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  return `${formattedDate} ${formattedTime}`;
}
</script>