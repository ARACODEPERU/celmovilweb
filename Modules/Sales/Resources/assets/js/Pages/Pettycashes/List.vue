<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { faGears } from "@fortawesome/free-solid-svg-icons";
import Pagination from '@/Components/Pagination.vue';
import ModalCashCreate from './ModalCashCreate.vue';
import Keypad from '@/Components/Keypad.vue';
import swal from 'sweetalert2';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { 
    Textarea, Input, Dropdown, Menu, MenuItem, Button, Select
} from 'ant-design-vue';
import Swal2 from 'sweetalert2';

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

const formExpense = useForm({
    petty_cash_id: null,
    description:'',
    amount: '',
    document:''

});

const displayModalExpense  = ref(false);
const openModalExpenseCreate = (id) => {
    formExpense.petty_cash_id = id;
    displayModalExpense.value = true;
};
const closeModalExpense = () => {
    formExpense.reset();
    displayModalExpense.value = false;
};

    
const createExpense = () => {
    formExpense.post(route('store_expense'), {
        forceFormData: true,
        errorBag: 'createExpense',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se Registro correctamente',
                icon: 'success',
            });
            closeModalExpense()
        },
    });
};

const formEdit = useForm({
    id: null,
    local_id: null,
    starting_amount: '',
    seller_name: ''
});

const displayModalEdit = ref(false);

const openModalEdit = (cash) => {
    formEdit.id = cash.id
    formEdit.local_id = cash.local_sale_id
    formEdit.starting_amount = cash.beginning_balance
    formEdit.seller_name = cash.seller_name
    
    displayModalEdit.value = true;
};

const closeModalEdit = () => {
    form.reset();
    displayModalEdit.value = false;
};

const editCash = () => {
    formEdit.put(route('pettycash.update',formEdit.id), {
        errorBag: 'editCash',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se Actualizado correctamente',
                icon: 'success',
            });
            closeModalEdit()
        },
    });
};
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
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('pettycash.index'))">
                                    <div class="grid grid-cols-3">
                                        <div class="col-span-3 sm:col-span-1 mr-2">
                                            <input v-mask="'##/##/####'" type="text" id="f1" aria-label="f1" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="col-span-3 sm:col-span-1">
                                            <input v-mask="'##/##/####'" type="text" id="f2" aria-label="d2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <div class="col-span-3 sm:col-span-2">
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
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white xl:pl-11">
                                        Acción
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Usuario
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Tienda
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Fecha Apertura
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Fecha Cerrado
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Ingreso por ventas
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Monto en Caja
                                    </th>
                                    <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                                        Gastos
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pettycash, index) in pettycashes.data" :key="pettycash.id" :class="  pettycash.state==1? '' : 'bg-gray-100 hover:bg-gray-200'">
                                    <td class="text-center text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        <Dropdown :placement="'bottomLeft'" arrow>
                                            <button class="border py-1.5 px-2 dropdown-button inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm" type="button">
                                                <font-awesome-icon :icon="faGears" />
                                            </button>
                                            <template #overlay>
                                                <Menu>
                                                    <MenuItem v-if="pettycash.state==1">
                                                        <a href="#" @click="openModalEdit(pettycash)" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            Editar
                                                        </a>
                                                    </MenuItem>
                                                    <MenuItem v-if="pettycash.state==1" >
                                                        <a href="#" @click="openModalExpenseCreate(pettycash.id)" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            Gastos
                                                        </a>
                                                    </MenuItem>
                                                    <MenuItem v-if="pettycash.state==1">
                                                        <a href="#" @click="closePettyCash(pettycash.id, pettycash.state)" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            Cerrar Caja
                                                        </a>
                                                    </MenuItem>
                                                    <MenuItem type="button" >
                                                        <Link :href="route('PettyCashReport', pettycash.id)" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            Reporte Caja
                                                        </Link>
                                                    </MenuItem>
                                                    <MenuItem v-if="pettycash.income==0">
                                                        <a @click="destroy(pettycash)" href="#" class="text-left block px-4 py-2 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Eliminar</a>
                                                    </MenuItem>
                                                </Menu>
                                            </template>
                                        </Dropdown>

                                    </td>
                                    <td class="text-center text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ pettycash.name_user }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ getLocal(pettycash.local_sale_id) }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ pettycash.date_opening }}<p class="text-sm">{{ pettycash.time_opening.slice(0, -3) }} hrs</p>
                                    </td>
                                    <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        <span v-if="pettycash.state==1"  class="bg-blue-800 text-white text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-blue-900 dark:text-blue-300">
                                            Abierto
                                        </span>
                                        <span v-else class="bg-gray-700 text-white text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-pink-900 dark:text-pink-300">
                                            {{ pettycash.date_closed}} {{ pettycash.time_closed.slice(0, -3)+" hrs"  }}
                                        </span>
                                    </td>
                                    <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ pettycash.income }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ pettycash.final_balance }}
                                    </td>
                                    <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
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
        <DialogModal :show="displayModalExpense" @close="closeModalExpense">
            <template #title>
                Registrar Gasto en CAJA
            </template>
            <template #content>

                <form>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="col-span-4">
                            <InputLabel id="formExpense_description" value="Descripción o Motivo" class="mb-1" />
                            <Textarea
                                id="formExpense_description"
                                v-model:value="formExpense.description"
                                placeholder="Escriba motivo del gasto"
                                :auto-size="{ minRows: 2, maxRows: 5 }"
                                autofocus
                            />
                            <InputError  :message="formExpense.errors.description" class="mt-2" />
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <InputLabel ref="formExpense_amount" value="Monto" />
                            <Input
                                id="formExpense_amount"
                                v-model:value="formExpense.amount"
                                placeholder="Monto del gasto"
                                type="text"
                            />
                            <InputError :message="formExpense.errors.amount" class="mt-2" />
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <InputLabel ref="formExpense_document" value="N° Documento" />
                            <Input
                                id="formExpense_document"
                                v-model:value="formExpense.document"
                                placeholder="N° de Recibo / Empresa"
                                type="text"
                            />
                            <InputError :message="formExpense.errors.document" class="mt-2" />
                        </div>
                    </div>
                </form>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModalExpense">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': formExpense.processing }"
                    :disabled="formExpense.processing"
                    @click="createExpense"
                >
                    Guardar
                </DangerButton>
            </template>
        </DialogModal>
        <DialogModal :show="displayModalEdit" @close="closeModalEdit">
            <template #title>
                Editar Caja Chica
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel value="Local" class="mb-1" />
                        <Select
                            class="w-full"
                            v-model:value="formEdit.local_id"
                            :options="locals.map((row)=>({value: row.id, label: row.description}))"
                        />
                        <InputError :message="formEdit.errors.local_id" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel value="Monto de Inicio" class="mb-1" />
                        <Input
                            v-model:value="formEdit.starting_amount"
                            type="text"
                        />
                        <InputError :message="formEdit.errors.starting_amount" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <InputLabel value="Nombre Vendedor" class="mb-1" />
                        <Input
                            v-model:value="formEdit.seller_name"
                            type="text"
                        />
                        <InputError :message="formEdit.errors.seller_name" class="mt-2" />
                    </div>
                </div>

            </template>

            <template #footer>
                <SecondaryButton @click="closeModalEdit">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': formEdit.processing }"
                    :disabled="formEdit.processing"
                    @click="editCash"
                >
                    Guardar
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
