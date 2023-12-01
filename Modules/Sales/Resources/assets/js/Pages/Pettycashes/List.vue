<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import { faTrashAlt, faPencilAlt, faPrint, faCashRegister, faFileExcel, faMoneyBill1Wave} from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue';
    import ModalCashEdit from './ModalCashEdit.vue';
    import ModalCashCreate from './ModalCashCreate.vue';
    import ModalExpenseCreate from './ModalExpenseCreate.vue';
    import Keypad from '@/Components/Keypad.vue';
    import swal from 'sweetalert2';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        pettycashes: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        locals: {
            type: Object,
            default: () => ({}),
        }
    });
    
    const form = useForm({
        search: {
            date_start: props.filters.date_start,
            date_end: props.filters.date_end
        },
    });

    const dataPettycash = useForm({
        pettycash: {
            type: Object,
            default: () => ({}),
        }
    });

    const formDelete = useForm({});

    function destroy(pettycash) {
        if (confirm("¿Estás seguro de que quieres eliminar?")) {
            formDelete.delete(route('pettycash.destroy', pettycash.id));
        }
    }

    function closePettyCash(id, state){
        if(state == 0){
            swal.fire({
                title: '¿Estás seguro de que quieres Cerrar la Caja?',
                confirmButtonText: 'SI',
            });
        }else{
            swal.fire({
                title: '¿Estás seguro de que quieres Cerrar la Caja?',
                showCancelButton: true,
                confirmButtonText: 'SI',
                cancelButtonText: `NO`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post(route('close_petty_cash', {id})).then(response => {
                        location.reload();
                    }).catch(error => console.log(error));
                } 
            })
        }
    }


function getLocal(id){
    let local_name;
    props.locals.forEach(local => {
    if(local.id == id){
        local_name = local.description;
    }
  });
  return local_name;
}

function openModalPettycashEdit(pettycash){
    dataPettycash.pettycash = pettycash;
}
</script>

<template>
    <AppLayout title="Cajas Chicas">
        <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Caja Chica</span>
                    </div>
                </li>
                </ol>
            </nav>
            <!-- Breadcrumb End -->
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-2">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('pettycash.index'))">
                                    <div class="grid grid-cols-3">
                                        <div class="col-span-3 sm:col-span-1 mr-2">
                                            <input v-mask="'##/##/####'" type="text" id="f1" aria-label="f1" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="col-span-3 sm:col-span-1">
                                            <input v-mask="'##/##/####'" type="text" id="f2" aria-label="d2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="col-span-3 sm:col-span-1">
                                            <button type="submit" class="p-2 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                <span class="sr-only">Search</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <Keypad>
                                    <template #botones>
                                        <ModalCashCreate :locals="locals" />
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th class="text-center py-4 px-4 text-sm font-medium text-black dark:text-white xl:pl-11">
                                        Acción
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Usuario
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Tienda
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Fecha Apertura
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Fecha Cerrado
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Ingreso por ventas
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Monto en Caja
                                    </th>
                                    <th class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                        Gastos
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pettycash, index) in pettycashes.data" :key="pettycash.id" :class="  pettycash.state==1? '' : 'bg-gray-100 hover:bg-gray-200'">
                                    <td class="text-center text-sm border-b border-stroke py-4 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        <div class="flex space-x-2">
                                            <template v-if="pettycash.state==1">
                                                <ModalExpenseCreate :petty_cash_id="pettycash.id" />
                                            </template>

                                            <button v-if="pettycash.state==1" 
                                            @click="openModalPettycashEdit(pettycash)" type="button" title="Editar" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-2 py-1 text-center mr-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            >
                                                <font-awesome-icon :icon="faPencilAlt" />
                                            </button>
                                            <button v-if="pettycash.income==0" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-2 py-1.5 mr-1 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                @click="destroy(pettycash)"
                                                title="Eliminar"
                                                >
                                                <font-awesome-icon :icon="faTrashAlt" />
                                            </button>

                                            <button  v-if="pettycash.state==1" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-2 py-1 text-center mr-1dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                                @click="closePettyCash(pettycash.id, pettycash.state)"
                                                title="Cerrar Caja"
                                            >
                                                <font-awesome-icon :icon="faCashRegister" />
                                            </button>

                                            <a v-if="pettycash.state==0" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-2 py-1 text-center mr-1 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                                :href="route('PettyCashReport', pettycash.id)"
                                                title="Reporte"
                                                >
                                                <font-awesome-icon :icon="faFileExcel" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center text-sm border-b border-stroke py-4 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        {{ pettycash.name_user }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ getLocal(pettycash.local_sale_id) }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ pettycash.date_opening }}<p class="text-sm">{{ pettycash.time_opening.slice(0, -3) }} hrs</p>
                                    </td>
                                    <td class="text-sm border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        <span v-if="pettycash.state==1"  class="bg-blue-800 text-white text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-blue-900 dark:text-blue-300">
                                            Abierto
                                        </span>
                                        <span v-else class="bg-gray-700 text-white text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-pink-900 dark:text-pink-300">
                                            {{ pettycash.date_closed}} {{ pettycash.time_closed.slice(0, -3)+" hrs"  }}
                                        </span>
                                    </td>
                                    <td class="text-sm border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ pettycash.income }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ pettycash.final_balance }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-4 px-4 dark:border-strokedark">
                                        {{ pettycash.expenses }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="pettycashes" />
                </div>
            </div>
        </div>
        <ModalCashEdit :locals="locals" :pettycash="dataPettycash.pettycash" />
    </AppLayout>
</template>
