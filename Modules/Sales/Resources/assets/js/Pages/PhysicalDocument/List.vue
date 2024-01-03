<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { faTimes, faCopy, faGears } from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue';
    import Keypad from '@/Components/Keypad.vue';
    import { ref } from 'vue';
    import swal from "sweetalert2";
    import { Link, router, useForm } from '@inertiajs/vue3';
    import { Badge } from 'flowbite-vue'
    import { ConfigProvider, Dropdown,Menu , MenuItem, Button } from 'ant-design-vue';

    const props = defineProps({
        sales: {
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
    
    const anularDocument = (id) => {
        swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, Anular!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return axios.delete(route('sale_physical_document_destroy', id)).then((res) => {
                    if (!res.data.success) {
                        swal.showValidationMessage(res.data.message)
                    }
                    return res
                });
            },
            allowOutsideClick: () => !swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                swal.fire({
                    title: 'Enhorabuena',
                    text: 'Se Eliminó correctamente',
                    icon: 'success',
                });
                router.visit(route('sale_physical_document_list'), { replace: true, method: 'get' });
            }
        });
    }
</script>

<template>
    <AppLayout title="Ventas">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Documento Físico</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Listado</span>
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
                                <form @submit.prevent="form.get(route('sale_physical_document_list'))">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <input v-model="form.search" type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por cliente">
                                    </div>
                                </form>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <Keypad>
                                    <template #botones>
                                        <Link :href="route('sale_physical_document_create')" class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Nuevo</Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <ConfigProvider>
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th class="py-2 px-2 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="text-center py-2 px-2 font-medium text-black dark:text-white xl:pl-11">
                                        Documento 
                                    </th>
                                    <th class="py-2 px-2 font-medium text-black dark:text-white">
                                        Fecha
                                    </th>
                                    <th class="py-2 px-2 font-medium text-black dark:text-white">
                                        Cliente
                                    </th>
                                    <th class="py-2 px-2 font-medium text-black dark:text-white">
                                        Total
                                    </th>
                                    <th class="py-2 px-2 font-medium text-black dark:text-white">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sale, index) in sales.data" :key="sale.id" >
                                    <td class="text-center border-b border-stroke py-2 px-2 pl-9 dark:border-strokedark xl:pl-11">
                                        <Button v-can="'sale_documento_fisico_eliminar'" type="dashed" @click="anularDocument(sale.id)" >
                                            Anular
                                        </Button>
                                    </td>
                                    <td class="text-center border-b border-stroke py-2 px-2 pl-9 dark:border-strokedark xl:pl-11">
                                        {{ sale.serie + '-' + sale.corelative }}  
                                    </td>
                                    <td class="border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ sale.document_date }}
                                    </td>
                                    <td class="border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ sale.client_rzn_social }}
                                    </td>
                                    <td class="text-right border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ sale.total }}
                                    </td>
                                    <td class="border-b border-stroke py-2 px-2 dark:border-strokedark">

                                        <Badge v-if="sale.status == 'R'" type="yellow">Registrado</Badge>
                                        <Badge v-else="sale.status == 'A'" type="red">Anulado</Badge>
                                        <!-- <Badge v-else type="red">Anulado</Badge> -->

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :data="sales" />
                        </ConfigProvider>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>