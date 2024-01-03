<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import Keypad from '@/Components/Keypad.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { ref, onMounted } from 'vue';
    import ModalLargeX from '@/Components/ModalLargeX.vue';
    import Swal from "sweetalert2";
    import { Link, router } from '@inertiajs/vue3';
    import { faQuestion } from "@fortawesome/free-solid-svg-icons";
    import InputError from '@/Components/InputError.vue';

    const props = defineProps({
        communications: {
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

    const displayModalCreateCommunication = ref(false);

    const closeModalCreateLowCommunication = () => {
        displayModalCreateCommunication.value = false;
    }
    const openModalCreateLowCommunication = () => {
        displayModalCreateCommunication.value = true;
    }

    

    onMounted(() => {
        activeMessage();
    });

    const displaySearchLoading = ref(false);

    const getCurrentDate = () => {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Los meses son base 0, por eso se suma 1
        const day = String(currentDate.getDate()).padStart(2, '0');

        // Formato de fecha: YYYY-MM-DD
        return  `${year}-${month}-${day}`;
        //formDocument.date_end = `${year}-${month}-${day}`;
    };

    const formVoided = useForm({
        searchDate: getCurrentDate(),
        documents: []
    });
    
    const searchDocumentEarring = () => {
        displaySearchLoading.value = true;
        axios.get(route('low_communication_search_date', formVoided.searchDate)).then((res) => {
            if (res.data.success) {
                formVoided.documents = res.data.documents
            }else{
                Swal.fire({
                    title: 'Información Importante',
                    text: 'No existen documentos pendientes para la fecha indicada',
                    icon: 'info'
                });
            }
            displaySearchLoading.value = false;
        });
    }

    const statusTicket = (id,ticket,index) => {
        
        let btnCheck = document.getElementById('btn-check-summary'+ index);
        let spCheck = document.getElementById('sp-check-summary'+ index);
        const originalOpacity = btnCheck.style.opacity;
        btnCheck.style.width = '120';
        btnCheck.style.cursor = 'not-allowed';
        spCheck.style.display = 'block';
        btnCheck.style.opacity = '0.35';
        axios.get(route('low_communication_check',[id,ticket])).then((res) => {
            if (res.data.success) {
                Swal.fire({
                    title: 'Información Importante',
                    text: res.data.message,
                    icon: 'success',
                });
                router.visit(route('low_communication_list'), { replace: true });
            }else{
                Swal.fire({
                    title: 'Error',
                    text: 'Codigo: '+ res.data.code + '<br> Descripcion: ' + res.data.message ,
                    icon: 'error',
                });
                router.visit(route('low_communication_list'), { replace: true });
            }
            
            btnCheck.style.width = '120';
            btnCheck.style.cursor = 'pointer';
            spCheck.style.display = 'none';
            btnCheck.style.opacity = originalOpacity;
        });
    }
    const deleteCommunication = (id,index) => {
        
        let btnCheck = document.getElementById('btn-delete-summary'+ index);
        let spCheck = document.getElementById('sp-delete-summary'+ index);
        btnCheck.style.width = '120';
        btnCheck.style.cursor = 'not-allowed';
        spCheck.style.display = 'block';
        btnCheck.style.opacity = '0.35';
        axios.get(route('low_communication_destroy',id)).then((res) => {
            if (res.data.success) {
                Swal.fire({
                    title: 'Información Importante',
                    text: 'Se elimino correctamente',
                    icon: 'success'
                });
                router.visit(route('low_communication_list'), { replace: true });
            }
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    
    const activeMessage = () => {
        Toast.fire({
            icon: 'info',
            title: 'Comunicacion de Baja',
            text: 'Para comunicar a SUNAT las anulaciones de facturas y sus notas de crédito/débito releacionadas, necesita hacerlo mediante el documento de comunicación de baja. El envío a los servicios de SUNAT se maneja de la misma forma que el resumen diario.'
        });
    }

    const saveVoided = () => {
        formVoided.processing = true;
        axios.post(route('low_communication_store'),formVoided).then((res) => {
            if (res.data.success) {
                Swal.fire({
                    title: 'Información Importante',
                    text: 'El resumen se creó y envió correctamente',
                    icon: 'success'
                });
                router.visit(route('low_communication_list'), { replace: true });
            }else{
                Swal.fire({
                    title: 'Error',
                    text: 'Codigo: '+ res.data.code + '<br> Descripcion: ' + res.data.message ,
                    icon: 'error'
                });
            }
            formVoided.reset();
            formVoided.processing = false;
        }).catch(function (error) {
            formVoided.processing = false;
            formVoided.errors = error.response.data.errors;
        });
    }
</script>
<template>
    <AppLayout title="Resumen">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Facturación Electrónica</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Comunicacion de Baja</span>
                            <font-awesome-icon @click="activeMessage" :icon="faQuestion" class="ml-1" />
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
                                <form @submit.prevent="form.get(route('low_communication_list'))">
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
                                            @click="openModalCreateLowCommunication()"
                                        >
                                            Crear Comunicación de baja
                                        </PrimaryButton>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th  class="py-2 px-4 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Nmr. Documento
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Fecha
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(communication, index) in communications.data" :key="communication.id">
                                    <tr :style="communication.status ==='registrado' ? '' : communication.status ==='Rechazado' ? 'color: #CF1504': communication.status ==='Enviado'? 'color: #03C73F' :'color: #051BC6'" :class="communication.invoice_status ==='registrado' ? 'border-b border-stroke' : ''">
                                        <td :rowspan="communication.status ==='registrado' || communication.status ==='Enviado' ? 1 : 2" class="text-center py-2 px-2 dark:border-strokedark">
                                            <button :id="'btn-check-summary'+index" @click="statusTicket(communication.id,communication.ticket,index)" v-if="communication.status ==='Enviado'" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                <svg :id="'sp-check-summary'+index" style="display: none;" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                </svg>
                                                Consultar
                                            </button>
                                            <button :id="'btn-delete-summary'+index" @click="deleteCommunication(communication.id,index)" v-if="communication.status ==='Rechazado'" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                <svg :id="'sp-delete-summary'+index" style="display: none;" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                </svg>
                                                Eliminar
                                            </button>
                                        </td>
                                        <td class="py-2 dark:border-strokedark">
                                            {{ communication.communication_name }}
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ communication.communication_date }}
                                        </td>
                                        <td  class="text-center py-2 px-2 dark:border-strokedark">
                                            <small>Estado Sunat:</small>
                                            {{ communication.status }}
                                        </td>
                                    </tr>
                                    <template v-if="communication.status == 'Rechazado' || communication.status == 'Aceptado'" >
                                        <tr :style="communication.status ==='Rechazado' ? 'color: #CF1504': 'color: #051BC6'" class="border-b border-stroke" >
                                            <td colspan="2" class="text-xs">
                                                <code v-if="communication.response_code != 0">
                                                    Código: {{ communication.response_code }}
                                                </code>
                                                <code>
                                                    Descripción: {{ communication.response_description }}
                                                </code>
                                            </td>
                                            <td class="text-center text-xs">
                                               <template v-if="communication.notes">
                                                    {{ communication.notes }}
                                               </template> 
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                            </tbody>
                        </table>
                        <Pagination :data="communications" />
                    </div>
                </div>
            </div>
        </div>
        <ModalLargeX
            :show="displayModalCreateCommunication"
            :onClose="closeModalCreateLowCommunication"
            :icon="'/img/papel.png'"
        >
            <template #title>
                Crear Comunicación de baja
            </template>
            <template #message>
                Buscar por Fecha de emisión documentos que faltantes de envio
            </template>
            <template #content>
                <div class="grid grid-cols-6">
                    <div class="col-span-6 sm:col-span-2">
                        <form class="flex items-center mb-4">   
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
                                    </svg>
                                </div>
                                <input v-model="formVoided.searchDate" type="date" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search branch name..." required>
                            </div>
                            <button @click="searchDocumentEarring" type="button" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg v-if="displaySearchLoading" aria-hidden="true" role="status" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                </svg>
                                <svg v-else class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                
                                <th scope="col" class="px-2 py-3">
                                    Tipo documento
                                </th>
                                <th style="width: 70px;" class="px-2 py-3 text-center">
                                    Serie y numero
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Fecha de emisión
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Cliente
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    total
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    estado
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Motivo de baja
                                </th>
                              </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, ko) in formVoided.documents" class="bg-white border-b border-stroke dark:bg-gray-900 dark:border-gray-700">
                                
                                <td class="px-2 py-2">
                                   {{ item.type_description }}
                                </td>
                                <td class="px-2 py-2 text-center">
                                    {{ item.invoice_serie }}-{{ item.number }}
                                </td>

                                <td class="px-2 py-2 text-center">
                                    {{ item.invoice_broadcast_date }}
                                </td>
                                <td class="px-2 py-2 text-left">
                                    {{ item.client_number }}-{{ item.client_rzn_social }}
                                </td>
                                <td class="px-2 py-2 text-right">
                                    {{ item.invoice_mto_imp_sale }}
                                </td>
                                <td class="px-2 py-2 text-center">
                                    <span v-if="item.status == 1" class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Registrado</span>
                                    <span v-else class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Anulado</span>
                                </td>
                                <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center mr-4">
                                        <input v-model="item.edit_low" type="checkbox" class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </th>
                                <td>
                                    <textarea v-model="item.description_low" class="invoice-imput" :style="!item.edit_low ? 'background: #5EE588;border-color: #5EE588;cursor: not-allowed':''" :disabled="!item.edit_low" ></textarea>
                                    <template v-for="error in formVoided.errors[`documents.${ko}.description_low`]">
                                        <InputError :message="error" class="mt-2" />
                                    </template>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <progress v-if="formVoided.progress" :value="formVoided.progress.percentage" max="100">
                        {{ formVoided.progress.percentage }}%
                    </progress>
                </div>
            </template>
            <template #buttons>
                <PrimaryButton class="mr-2"
                :class="{ 'opacity-25': formVoided.processing }" :disabled="formVoided.processing"
                @click="saveVoided()"
                >
                    <svg v-show="formVoided.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                    </svg>
                    Guardar
                </PrimaryButton> 
            </template>
        </ModalLargeX>
    </AppLayout>
</template>
<style scoped>
.invoice-textarea{
    margin: 0px !important;
    padding: 1px !important;
    width: 100% !important;
    height: 40px !important;
    font-size: 12px;
}
</style>