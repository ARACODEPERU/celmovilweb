<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import { faTimes, faCopy, faPrint, faWarehouse } from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue';
    import Keypad from '@/Components/Keypad.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { ref } from 'vue';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import swal from "sweetalert";
    import { Link } from '@inertiajs/vue3';

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
    
    const printTicket = (id) => {
        //window.location.href = "../pdf/sales/ticket/" + id;
        let url = route('ticketpdf_sales',id)
        window.open(url, "_blank");
    }


    const displayModalPrint = ref(false);

    const formPrint = useForm({
        date: '',
    });

    const openPrintSaleDay = async () => {
        
        var fecha = new Date(); //Fecha actual
        var mes = fecha.getMonth()+1; //obteniendo mes
        var dia = fecha.getDate(); //obteniendo dia
        var ano = fecha.getFullYear(); //obteniendo año
        if(dia<10)dia='0'+dia; //agrega cero si el menor de 10
        if(mes<10)mes='0'+mes //agrega cero si el menor de 10
        fecha = ano + "-" + mes + "-" + dia;
        formPrint.date = fecha;
        displayModalPrint.value = true;
    }
    const closePrintSaleDay = async () => {
        displayModalPrint.value = false;
    }

    const printSales = () => {
        let url = route('print_sale_user',formPrint.date)
        window.open(url, "_blank");
        //window.location.href = "../print/sales/user/" + formPrint.date;
    }

    const formDelete= useForm({});

    const deleteSale = (id) => {
        swal({
            title: "Estas seguro",
            text: "No podrás revertir esto!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                formDelete.delete(route('sales.destroy',id),{
                    preserveScroll: true,
                    onSuccess: () => {
                        swal('Venta Anulada correctamente');
                    }
                });
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ventas</span>
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
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('sales.index'))">
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
                                        <PrimaryButton
                                            class="mr-2"
                                            @click="openPrintSaleDay()"
                                        >
                                            Imprimir Ventas Del día
                                        </PrimaryButton>
                                        <Link :href="route('sales.create')" class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Nuevo</Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th class="py-4 px-4 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                        #
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Nmr. Ticket
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Fecha
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Cliente
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Total
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sale, index) in sales.data" :key="sale.id" >
                                    <td class="text-center border-b border-stroke py-4 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        <button @click="printTicket(sale.id)" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <font-awesome-icon :icon="faPrint" />
                                        </button>
                                        <button v-role="'admin'" type="button" class="px-3 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                            @click="deleteSale(sale.id)"
                                            >
                                            <font-awesome-icon :icon="faTimes" />
                                        </button>
                                        <Link v-role="'admin'" type="button" class="px-2.5 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                                            :href="route('saledocuments_create_from_ticket',sale.id)"
                                            >
                                            <font-awesome-icon :icon="faCopy" />
                                        </Link>
                                    </td>
                                    <td class="text-center border-b border-stroke py-4 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="w-32 border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ sale.serie }}-{{ sale.number }}
                                    </td>
                                    <td class="border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ sale.created_at }}
                                    </td>
                                    <td class="border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ sale.full_name }}
                                    </td>
                                    <td class="text-right border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ sale.total }}
                                    </td>
                                    <td class="border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        <span v-if="sale.status == 1" class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Registrado</span>
                                        <span v-else class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Anulado</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :data="sales" />
                    </div>
                </div>
            </div>
        </div>
        <ModalSmall
            :show="displayModalPrint"
            :onClose="closePrintSaleDay"
        >
            <template #title>
                Imprimir Ventas del Día
            </template>
            <template #content>
                <input type="date" v-model="formPrint.date"
                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none dark:text-white dark:bg-gray-700"
                />
            </template>
            <template #buttons>
               <PrimaryButton
                    @click="printSales()"
                    class="mr-2"
               >Imprimir</PrimaryButton> 
            </template>
        </ModalSmall>
    </AppLayout>
</template>