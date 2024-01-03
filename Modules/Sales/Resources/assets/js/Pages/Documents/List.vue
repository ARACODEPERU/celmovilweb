<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import { faGears } from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue';
    import Keypad from '@/Components/Keypad.vue';
    import GreenButton from '@/Components/GreenButton.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { ref, onMounted } from 'vue';
    import ModalLargeX from '@/Components/ModalLargeX.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import DialogModal from '@/Components/DialogModal.vue';
    import Swal from "sweetalert2";
    import { Link, router } from '@inertiajs/vue3';
    import { ConfigProvider, Dropdown,Menu,MenuItem,Button } from 'ant-design-vue';

    const props = defineProps({
        documents: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        affectations: {
            type: Object,
            default: () => ({}),
        },
        unitTypes:{
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        search: props.filters.search,
    });
    
    const displayModalDetails = ref(false);
    const documentDetails = ref([]);
    const disabledButtonDetailsSave = ref(false);
    const opemModalDetails = async (sales) => {
        if(sales.invoice_status ==='registrado' || sales.invoice_status ==='Rechazada' || sales.invoice_status ==='Pendiente'){
            disabledButtonDetailsSave.value = false
        }else{
            disabledButtonDetailsSave.value = true
        }

        documentDetails.value = sales.documents[0];
        initializeDropdownItems();
        displayModalDetails.value = true;
    }

    const closeModalDetails = async () => {
        displayModalDetails.value = false;
        showteButtonSave.value = false;
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

    const sendSunatDocument = (document) => {
        initializeDropdownItems();
        Swal.fire({
            title: document.serie+'-'+document.number,
            text: 'Enviar documento',
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return axios.get(route('saledocuments_send', [document.document_id,document.invoice_type_doc])).then((res) => {
                    if (!res.data.success) {
                        var cadena = `Error código: ${res.data.code}<br>Descripción:${res.data.message}`;
                        let notes = res.data.notes;
                        if (notes) {
                            cadena += `<br>Nota: ${notes}`;
                        }
                        Swal.showValidationMessage(cadena)
                        router.visit(route('saledocuments_list'), { replace: true });
                    }
                    return res
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                var cadena = "";
                let array = JSON.parse(result.value.data.notes);
                for (var i = 0; i < array.length; i++) {
                    cadena += array[i] + "<br>";
                }

                Swal.fire({
                    title: `${result.value.data.message}`,
                    html: `${cadena}`,
                    icon: 'success',
                }).then(() => {
                    router.visit(route('saledocuments_list'),{
                        method: 'get'
                    });
                });

            }
        });
    }
    const dropdownItems = ref([]);

    const toggleDropdown = (index) => {
        dropdownItems.value = dropdownItems.value.map((item, i) => ({
            ...item,
            showDropdown: i === index ? !item.showDropdown : false
        }));
    };
    const initializeDropdownItems = () => {
        dropdownItems.value = props.documents.data.map(() => ({ showDropdown: false }));
    };

    onMounted(() => {
        initializeDropdownItems();
    });

    const getAffectation = (id) => {
        const selectedAffectation = props.affectations.find(affectation => affectation.id === id);
        //console.log(selectedAffectation.description)
        if (selectedAffectation) {
            return selectedAffectation.description;
        } else {
            return null;
        }
    }
    const getUnitTypes = (id) => {
        const selectedUnitType = props.unitTypes.find(unitType => unitType.id === id);
        //console.log(selectedAffectation.description)
        if (selectedUnitType) {
            return selectedUnitType.description;
        } else {
            return null;
        }
    }
    const showteButtonSave = ref(false);
    const editDetailsDocument = () => {
        showteButtonSave.value = !showteButtonSave.value;
    }

    const saveChangesDetails = () =>{
        axios.post(route('saledocuments_update_details'), documentDetails.value ).then((response) => {
            if(response.data.success){
                Swal.fire({
                    title: `Enhorabuena`,
                    html: `${response.data.message}`,
                    icon: 'success',
                }).then(() => {
                    router.visit(route('saledocuments_list'),{
                        method: 'get'
                    });
                });
            }else{
                Swal.fire({
                    title: `Error`,
                    html: `${response.data.message}`,
                    icon: 'error',
                });
            }
        });
    };
    const calculateItemTotals = (key) => {
        let c = parseFloat(documentDetails.value.items[key].quantity) ?? 0;
        let p = parseFloat(documentDetails.value.items[key].price_sale) ?? 0;
        let d = parseFloat(documentDetails.value.items[key].mto_discount) ?? 0;

        p = p - d;

        let st = (c * p);

        // Verificar si el resultado es NaN y asignar 0 en su lugar
        if (isNaN(st)) {
            st = 0;
        }

        documentDetails.value.items[key].mto_total = st.toFixed(2);

    }

    const downloadDocument = (id,type,file) => {
        let url = route('saledocuments_download',[id, type,file])
        window.open(url, "_blank");      
    }

    const displayEditDocument = ref(false);
    const formHead = useForm({
        client_id: null,
        id: null,
        name: null,
        client_number: null,
        client_rzn_social: null,
        client_address: null,
        client_ubigeo_code: null,
        client_ubigeo_description: null,
        client_phone: null,
        client_email: null,
        invoice_broadcast_date: null,
        invoice_due_date: null
    });
    const closeModalEditDocument = () => {
        displayEditDocument.value = false ;
    }
    const showModalEditDocument = (document) => {
        formHead.client_id = document.client_id;
        formHead.id = document.document_id;
        formHead.name = document.serie+'-'+document.number;
        formHead.client_number = document.client_number;
        formHead.client_rzn_social = document.client_rzn_social;
        formHead.client_address = document.client_address;
        formHead.client_ubigeo_code = document.client_ubigeo_code;
        formHead.client_ubigeo_description = document.client_ubigeo_description;
        formHead.client_phone = document.client_phone;
        formHead.client_email = document.client_email;
        formHead.invoice_broadcast_date = document.invoice_broadcast_date;
        formHead.invoice_due_date = document.invoice_due_date;
        displayEditDocument.value = true ;
    }

    const saveHeadDocument = () => {
        formHead.post(route('saledocuments_update_head'), {
            preserveScroll: true,
            onSuccess: () => {
                Swal.fire({
                    title: `Enhorabuena`,
                    html: `Documento Actualizado correctamente`,
                    icon: 'success',
                });
                formHead.reset();
                router.visit(route('saledocuments_list'),{
                    method: 'get'
                });
            }
        });
    }
</script>

<template>
    <AppLayout title="Documentos">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Lista de Documentos</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('saledocuments_list'))">
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
                                        <Link :href="route('saledocuments_create')" class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Nuevo</Link>
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
                                    <th style="width: 75px;" class="py-1 px-4 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="py-1 px-4 font-medium text-black dark:text-white">
                                        Nmr. Documento
                                    </th>
                                    <th class="py-1 px-4 font-medium text-black dark:text-white">
                                        Fecha
                                    </th>
                                    <th class="py-1 px-4 font-medium text-black dark:text-white">
                                        Cliente
                                    </th>
                                    <th class="py-1 px-4 font-medium text-black dark:text-white">
                                        Total
                                    </th>
                                    <th class="py-1 px-4 font-medium text-black dark:text-white">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(document, index) in documents.data" :key="document.id">
                                    <tr :style="document.invoice_status ==='registrado' || document.invoice_status ==='Pendiente' ? '' : document.invoice_status ==='Rechazada' ? 'color: #CF1504': 'color: #051BC6'" :class="document.invoice_status ==='registrado' || document.invoice_status ==='Pendiente' ? 'border-b border-stroke' : ''">
                                        <td :rowspan="document.invoice_status ==='registrado' || document.invoice_status ==='Pendiente' ? 1 : 2" class="text-center py-1 px-4 dark:border-strokedark">
                                            <Dropdown :placement="'bottomLeft'">
                                                <button class="border py-1.5 px-2 dropdown-button inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm" type="button">
                                                    <font-awesome-icon :icon="faGears" />
                                                </button>
                                                <template #overlay>
                                                    <Menu>
                                                        <MenuItem v-if="document.invoice_status != 'Aceptada'">
                                                            <Button @click="showModalEditDocument(document)" type="button" >Editar</Button>
                                                        </MenuItem>
                                                        <MenuItem v-if="document.invoice_status != 'Aceptada'">
                                                            <Button v-can="'invo_documento_envio_sunat'" @click="sendSunatDocument(document)" type="button" >Enviar a Sunat</Button>
                                                        </MenuItem>
                                                        <MenuItem>
                                                            <Button @click="opemModalDetails(document)" type="button" >Detalles</Button>
                                                        </MenuItem>
                                                        <MenuItem v-if="document.invoice_status != 'Aceptada'">
                                                            <Button @click="deletePanel(index,board.id)" type="button" >Eliminar</Button>
                                                        </MenuItem>
                                                        <MenuItem v-if="document.invoice_status === 'Aceptada'">
                                                            <Button @click="downloadDocument(document.document_id,document.invoice_type_doc,'PDF')"
                                                                type="button"
                                                                >Imprimir PDF</Button>
                                                        </MenuItem>
                                                        <MenuItem v-if="document.invoice_status === 'Aceptada'">
                                                            <Button @click="downloadDocument(document.document_id,document.invoice_type_doc,'XML')" type="button" >Descargar XML</Button>
                                                        </MenuItem>
                                                        <MenuItem v-if="document.invoice_status === 'Aceptada'" >
                                                            <Button @click="downloadDocument(document.document_id,document.invoice_type_doc,'CDR')" type="button" >Descargar CDR</Button>
                                                        </MenuItem>
                                                    </Menu>
                                                </template>
                                            </Dropdown>
                                        </td>
                                        <td class="w-32 py-1 dark:border-strokedark">
                                            {{ document.serie }}-{{ document.number }}
                                        </td>
                                        <td class="py-1 px-4 dark:border-strokedark">
                                            {{ document.created_at }}
                                        </td>
                                        <td class="py-1 px-4 dark:border-strokedark">
                                            {{ document.full_name }}
                                        </td>
                                        <td class="text-right py-1 px-4 dark:border-strokedark">
                                            {{ document.total }}
                                        </td>
                                        <td  class="text-center py-1 px-4 dark:border-strokedark">
                                            <span v-if="document.status == 1" class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Activa</span>
                                            <span v-else class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Anulado</span>
                                        </td>
                                    </tr>
                                    <template v-if="document.invoice_status =='Rechazada' || document.invoice_status === 'Aceptada' || document.invoice_status === 'Anulada'" >
                                        <tr :style="document.invoice_status ==='registrado' ? '' : document.invoice_status ==='Rechazada' ? 'color: #CF1504': 'color: #051BC6'" class="border-b border-stroke" >
                                            <td colspan="4" class="text-xs">
                                                <code v-if="document.invoice_response_code != 0">
                                                    Código: {{ document.invoice_response_code }}
                                                </code>
                                                <code>
                                                    Descripción: {{ document.invoice_response_description }}
                                                </code>
                                            </td>
                                            <td class="text-center text-xs">
                                                <small>Estado Sunat:</small>
                                                {{ document.invoice_status }}
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                            </tbody>
                        </table>
                        <Pagination :data="documents" />
                        </ConfigProvider>
                    </div>
                </div>
            </div>
        </div>
        <ModalLargeX
            :show="displayModalDetails"
            :onClose="closeModalDetails"
            :icon="'/img/bienes.png'"
        >
            <template #title>
                Detalles de la venta
            </template>
            <template #message>
                Lista de Productos o Servicios Vendidos
            </template>
            <template #content>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th style="width: 70px;" class="px-6 py-3 text-center">
                                    Código
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descripción
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Medida
                                </th>
                                <th style="display: none;" scope="col" class="px-6 py-3">
                                    Tipo de Afectación del IGV
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Precio
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Sub Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descuento
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,ko) in documentDetails.items" class="bg-white border-b border-stroke dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ item.cod_product }}
                                </th>
                                <td class="px-4 py-2">
                                    <span v-show="!showteButtonSave">{{ item.decription_product }}</span>
                                    <textarea v-show="showteButtonSave" v-model="item.decription_product" class="invoice-textarea"></textarea>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <span v-show="!showteButtonSave">{{ getUnitTypes(item.unit_type) }}</span>
                                    <select v-show="showteButtonSave" v-model="item.unit_type" class="invoice-select">
                                        <option v-for="(row, ci) in unitTypes" :value="row.id">{{ row.description }}</option>
                                    </select>
                                </td>
                                <td style="display: none;" class="px-4 py-2">
                                    <span v-show="!showteButtonSave">{{ getAffectation(item.type_afe_igv) }}</span>
                                    <select v-show="showteButtonSave" v-model="item.type_afe_igv" class="invoice-select">
                                        <option v-for="(row, ci) in affectations" :value="row.id">{{ row.description }}</option>
                                    </select>
                                </td>
                                <td style="width: 110px;" class="px-4 py-2 text-right">
                                    <span v-show="!showteButtonSave">{{ item.quantity }}</span>
                                    <input v-show="showteButtonSave" v-model="item.quantity" @input="calculateItemTotals(ko)"  class="invoice-imput text-right" type="text" />
                                </td>
                                <td style="width: 110px;" class="px-4 py-2 text-right">
                                    <span v-show="!showteButtonSave">{{ item.price_sale }}</span>
                                    <input v-show="showteButtonSave" v-model="item.price_sale" @input="calculateItemTotals(ko)"  class="invoice-imput text-right" type="text" />
                                </td>
                                <td style="width: 120px;" class="px-4 py-2 text-right">
                                    {{ (item.quantity * item.price_sale).toFixed(2) }}
                                </td>
                                <td style="width: 120px;" class="px-4 py-2 text-right">
                                    <span v-show="!showteButtonSave">{{ item.mto_discount }}</span>
                                    <input v-show="showteButtonSave" v-model="item.mto_discount" @input="calculateItemTotals(ko)"  class="invoice-imput text-right" type="text" />
                                </td>
                                <td style="width: 120px;" class="px-4 py-2 text-right">
                                    {{ item.mto_total }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            <template #buttons>
                <GreenButton
                    :disabled="disabledButtonDetailsSave"
                    @click="editDetailsDocument"
                    class="mr-2"
               >Modificar</GreenButton> 
               <PrimaryButton v-if="showteButtonSave" class="mr-2"
               @click="saveChangesDetails"
               >Guardar Cambios</PrimaryButton> 
            </template>
        </ModalLargeX>
        <DialogModal :show="displayEditDocument" @close="closeModalEditDocument">
            <template #title>
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-800 sm:mx-0 sm:h-10 sm:w-10">
                    <!-- Heroicon name: outline/check -->
                        <img :src="'/img/editar-codigo.png'" />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            {{ formHead.name  }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Editar Cabecera del Documento
                            </p>
                        </div>
                    </div>
                </div>
            </template>

            <template #content>
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="client_number" value="Cliente Num. Doc." />
                        <TextInput id="client_number" v-model="formHead.client_number" type="text" class="block w-full mt-1"
                            autofocus />
                        <InputError :message="formHead.errors.client_number" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel for="client_rzn_social" value="Cliente Razon Social" />
                        <TextInput id="client_rzn_social" v-model="formHead.client_rzn_social" type="text" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.client_rzn_social" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="client_address" value="Cliente Dirección" />
                        <TextInput id="client_address" v-model="formHead.client_address" type="text" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.client_address" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="client_ubigeo_description" value="Departamento-Provincia-Distrito" />
                        <TextInput id="client_ubigeo_description" v-model="formHead.client_ubigeo_description" type="text" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.client_ubigeo_code" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="client_phone" value="Teléfono" />
                        <TextInput id="client_phone" v-model="formHead.client_phone" type="text" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.client_phone" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="client_email" value="Correo electrónico" />
                        <TextInput id="client_email" v-model="formHead.client_email" type="text" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.client_email" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="invoice_broadcast_date" value="Fecha Emisión" />
                        <TextInput id="invoice_broadcast_date" v-model="formHead.invoice_broadcast_date" type="date" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.invoice_broadcast_date" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="invoice_due_date" value="Fecha Vencimiento" />
                        <TextInput id="invoice_due_date" v-model="formHead.invoice_due_date" type="date" class="block w-full mt-1"/>
                        <InputError :message="formHead.errors.invoice_due_date" class="mt-2" />
                    </div>
                </div>
            </template>

            <template #footer>
                <PrimaryButton class="mr-2"
                    @click="saveHeadDocument"
                >
                    Guardar Cambios
                </PrimaryButton> 
                <SecondaryButton @click="closeModalEditDocument">
                    Cancel
                </SecondaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
<style scoped>
.invoice-select{
    margin: 0px !important;
    padding: 1px !important;
    height: 26px !important;
    width: 100% !important;
    font-size: 12px;
}
.invoice-imput{
    margin: 0px !important;
    padding: 1px !important;
    height: 26px !important;
    width: 100% !important;
    font-size: 12px;
}
.invoice-textarea{
    margin: 0px !important;
    padding: 1px !important;
    width: 100% !important;
    font-size: 12px;
}
</style>