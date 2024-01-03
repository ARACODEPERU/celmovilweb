<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DangerButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import SearchClients from './Partials/SearchClients.vue';
    import SearchProducts from './Partials/SearchProducts.vue';
    import { faPlus, faXmark, faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import { ref, onMounted } from 'vue';
    import Swal2 from 'sweetalert2';
    import { Link, router } from '@inertiajs/vue3';

    const props = defineProps({
        payments: {
            type: Object,
            default: () => ({}),
        },
        client: {
            type: Object,
            default: () => ({}),
        },
        documentTypes: {
            type: Object,
            default: () => ({}),
        },
        company:{
            type: Object,
            default: () => ({}),
        },
        saleDocumentTypes:{
            type: Object,
            default: () => ({}),
        },
        departments: {
            type: Object,
            default: () => ({}),
        },
        unitTypes: {
            type: Object,
            default: () => ({}),
        },
        type_operation: {
            type: String,
            default: () => ({}),
        },
        taxes: {
            type: Object,
            default: () => ({}),
        }
    });

    const formDocument = useForm({
        client_id: props.client.id,
        client_name: props.client.number+"-"+props.client.full_name,
        client_rzn_social: props.client.full_name,
        client_ubigeo: props.client.ubigeo,
        client_dti: props.client.document_type_id,
        client_number: props.client.number,
        client_ubigeo_description: props.company.city,
        client_direction: props.company.fiscal_address,
        client_phone: props.client.telephone,
        client_email: props.client.email,
        sale_documenttype_id: 2,
        type_operation: props.type_operation,
        serie: null,
        date_issue: null,
        date_end: null,
        items:[],
        total_discount: 0,
        total_igv: 0,
        percentage_igv: 0,
        total: 0,
        total_taxed: 0, //operaciones gravadas
        payments: [{
            type:1,
            reference: null,
            amount:0
        }],
    });

    const series = ref([]);

    const getSeriesByDocumentType = () => {
        let did = formDocument.sale_documenttype_id;
        axios.get(route('sale_document_series',did)).then((res) => {
            if (res.data.status) {
                series.value = res.data.series;
                formDocument.serie = series.value[0].id;
            } else {
                Swal2.fire({
                    title: 'Información Importante',
                    text: 'No existe serie para este local o tipo de documento',
                    icon: 'info',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ok',
                    denyButtonText: `Crear serie`,
                }).then((result) => {
                    if (result.isDenied) {
                        router.visit(route('establishments.index'),{
                            method: 'get'
                        });
                    }
                })
            }
        });
    }

    onMounted(() => {
        getSeriesByDocumentType();
        getCurrentDate();
        startTaxes();
    });
    
    const taxes = ref({});
    const startTaxes = () => {
        
        let igv = parseFloat(props.taxes.igv);
        let icbper = parseFloat(props.taxes.icbper);

        let xa = {
            nfactorIGV: (igv / 100) + 1,
            rfactorIGV: (igv / 100),
            icbper: icbper
        }
        taxes.value = xa;
    }
    const getCurrentDate = () => {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Los meses son base 0, por eso se suma 1
        const day = String(currentDate.getDate()).padStart(2, '0');

        // Formato de fecha: YYYY-MM-DD
        formDocument.date_issue = `${year}-${month}-${day}`;
        formDocument.date_end = `${year}-${month}-${day}`;
    };

    const getDataClient = async (data) => {
        if(formDocument.sale_documenttype_id == 2){
            formDocument.client_id = data.id;
            formDocument.client_name = data.number+"-"+data.full_name;
            formDocument.client_rzn_social = data.full_name;
            formDocument.client_ubigeo_description = data.city;
            formDocument.client_ubigeo = data.ubigeo;
            formDocument.client_direction = data.address;
            formDocument.client_dti = data.document_type_id;
            formDocument.client_number = data.number;
            formDocument.client_phone = data.telephone;
            formDocument.client_email = data.email;
        }else{
            if(data.document_type_id == '6'){
                formDocument.client_id = data.id;
                formDocument.client_name = data.number+"-"+data.full_name;
                formDocument.client_ubigeo_description = data.city;
                formDocument.client_ubigeo = data.ubigeo;
                formDocument.client_direction = data.address;
                formDocument.client_dti = data.document_type_id;
                formDocument.client_number = data.number;
                formDocument.client_phone = data.telephone;
                formDocument.client_email = data.email;
                formDocument.client_rzn_social = data.full_name;
            }else{
                Swal2.fire({
                    title: 'Información Importante',
                    text: "El cliente no cuenta con ruc para emitir una factura",
                    icon: 'info',
                });
            }
        }
        displayModalClientSearch.value = false;
        
    }

    const displayModalClientSearch = ref(false);
    const saleDocumentTypesId = ref({});
    
    const openModalClientSearch = () => {
        displayModalClientSearch.value = true;
        saleDocumentTypesId.value = formDocument.sale_documenttype_id
    }
    const closeModalClientSearch = () => {
        saleDocumentTypesId.value =  null;
        displayModalClientSearch.value = false;
    }
    const newItems = () => {
        let item = {
            id: null,
            description: null,
            is_product: true,
            unit_type: 'NIU',
            quantity: 1,
            unit_price: 0,
            discount: 0,
            total: 0,
            afe_igv: 10,
            size: null,
            m_igv: 0,
            presentations: null,
            icbper: false
        }
        formDocument.items.push(item);
    }
    
    const removeItem = (key) => {
        let t = parseFloat(formDocument.items[key].total);
        formDocument.total = parseFloat(formDocument.total) - t;
        formDocument.items.splice(key,1);
    }

    const calculateTotals = (key) => {
        let c = parseFloat(formDocument.items[key].quantity) ?? 0;
        let p = parseFloat(formDocument.items[key].unit_price) ?? 0;
        let d = parseFloat(formDocument.items[key].discount) ?? 0;

        let vu = p / taxes.value.nfactorIGV; //valor unitario
        let fa = ((d * 100) / p) / 100; //factor del descuento
        let md = fa * vu * c; //monto del descuento
        let bi = (vu * c) - md; //base igv
        let mi = bi * taxes.value.rfactorIGV; //total igv por item
        let st = ((vu * c) - md) + mi;
        let vs = (vu * c) - md;
        // Verificar si el resultado es NaN y asignar 0 en su lugar
        if (isNaN(st)) {
            st = 0;
        }
        if (isNaN(mi)) {
            mi = 0;
        }
        if (isNaN(vs)) {
            vs = 0;
        }
        formDocument.items[key].m_igv = mi.toFixed(2);
        formDocument.items[key].total = st.toFixed(2);
        formDocument.items[key].v_sale = vs.toFixed(2);

        // Calcular la suma de los totales de todos los items
        formDocument.total = formDocument.items.reduce((acc, item) => acc + parseFloat(item.total), 0).toFixed(2);
        formDocument.total_discount = formDocument.items.reduce((acc, item) => acc + (parseFloat(item.discount)*c), 0).toFixed(2);
        formDocument.total_taxed = formDocument.items.reduce((acc, item) => acc + parseFloat(item.v_sale), 0).toFixed(2);
        formDocument.total_igv = formDocument.items.reduce((acc, item) => acc + parseFloat(item.m_igv), 0).toFixed(2);
        formDocument.payments[0].amount = formDocument.total;
        
    }
    ////imprimir documento
    const downloadDocument = (id,type,file) => {
        let url = route('saledocuments_download',[id, type,file])
        window.open(url, "_blank");      
    }

    const saveDocument = () => {
        
        formDocument.processing = true

        if(formDocument.serie){
            if(formDocument.client_dti != 6 && formDocument.sale_documenttype_id == 1){
                Swal2.fire({
                    title: 'Información Importante',
                    text: "El cliente debe tener ruc para emitir una factura",
                    icon: 'error',
                });
                formDocument.processing = false
                return;
                
            }

            axios.post(route('saledocuments_store'), formDocument ).then((res) => {
                formDocument.client_id = props.client.id,
                formDocument.client_name = props.client.number+"-"+props.client.full_name,
                formDocument.client_ubigeo = props.client.ubigeo,
                formDocument.client_dti = props.client.document_type_id,
                formDocument.client_number = props.client.number,
                formDocument.client_ubigeo_description = props.company.city,
                formDocument.client_direction = props.company.fiscal_address,
                formDocument.client_phone = props.client.telephone,
                formDocument.client_email = props.client.email,
                formDocument.sale_documenttype_id = 2,
                formDocument.type_operation = props.type_operation,
                formDocument.serie = null
                formDocument.items = [];
                formDocument.total_discount = 0;
                formDocument.total_igv = 0;
                formDocument.total = 0;
                formDocument.total_taxed = 0;
                formDocument.payments = [{
                    type:1,
                    reference: null,
                    amount:0
                }];
                getSeriesByDocumentType();
                formDocument.processing =  false;
                Swal2.fire({
                    title: 'Comprobante creado con éxito',
                    text: "¿deseas enviar a sunat y/o Imprimir?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Enviar Ahora',
                    cancelButtonText: 'Seguir vendiendo',
                    showDenyButton: true,
                    denyButtonText: `Solo Imprimir`,
                    denyButtonColor: '#5E5A5A'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(res.data.invoice_type_doc == '01'){
                            sendSunatDocumentCreated(res.data)
                        }else{
                            Swal2.fire({
                                title: 'Información Importante',
                                text: "Las boletas se envian mediante un resumen",
                                icon: 'info',
                            });
                        }
                    } else if (result.isDenied) {
                        downloadDocument(res.data.id,res.data.invoice_type_doc,'PDF')
                    }
                });
            }).catch(function (error) {
                console.log(error)
            });
        }else{
            Swal2.fire({
                title: 'Información Importante',
                text: "Elejir serie de documento",
                icon: 'error',
            });
            formDocument.processing = false
            return;
        }
    }
    const addPayment = () => {
        let ar = {
            type:1,
            reference: null,
            amount:0
        };
        formDocument.payments.push(ar);
    };
    const removePayment = (index) => {
        if(index>0){
            formDocument.payments.splice(index,1);
        }
    };

    const displaySearchProducts = ref(false);
    const closeSearchProducus = () => {
        displaySearchProducts.value = false;
    }
    
    const getDataTable = async (data) => {
        let c = parseFloat(data.quantity) ?? 0;
        let p = parseFloat(data.unit_price) ?? 0;
        let d = parseFloat(data.discount) ?? 0;

        let vu = p / taxes.value.nfactorIGV; //valor unitario
        let fa = ((d * 100) / p) / 100; //factor del descuento
        let md = fa * vu * c; //monto del descuento
        let bi = (vu * c) - md; //base igv
        let mi = bi * taxes.value.rfactorIGV; //total igv por item
        let st = ((vu * c) - md) + mi;
        let vs = (vu * c) - md;
        
        // Verificar si el resultado es NaN y asignar 0 en su lugar
        if (isNaN(st)) {
            st = 0;
        }
        if (isNaN(mi)) {
            mi = 0;
        }
        if (isNaN(vs)) {
            vs = 0;
        }
        if (isNaN(md)) {
            md = 0;
        }
        data.m_igv = mi.toFixed(2);
        data.total = st.toFixed(2);
        data.v_sale = vs.toFixed(2);

        let tt = parseFloat(formDocument.total) + st;
        let td = parseFloat(formDocument.total_discount) + md;
        let tx = parseFloat(formDocument.total_taxed) + vs;
        let ti = parseFloat(formDocument.total_igv) + mi;
        // Calcular la suma de los totales de todos los items

        formDocument.total = tt.toFixed(2);
        formDocument.total_discount = td.toFixed(2);
        formDocument.total_taxed = tx.toFixed(2);
        formDocument.total_igv = ti.toFixed(2);
        formDocument.items.push(data);
        formDocument.payments[0].amount = formDocument.total;
        displaySearchProducts.value = false;
    }

    const sendSunatDocumentCreated = (document) => {
        Swal2.fire({
            title: document.invoice_serie+'-'+document.number,
            text: 'Enviar documento',
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            showLoaderOnConfirm: true,
            clickOutside: false,
            preConfirm: () => {
                return axios.get(route('saledocuments_send', [document.id,document.invoice_type_doc])).then((res) => {
                    if (!res.data.success) {
                        var cadena = `Error código: ${res.data.code}<br>Descripción:${res.data.message}`;
                        let notes = res.data.notes;
                        if (notes) {
                            cadena += `<br>Nota: ${notes}`;
                        }
                        Swal2.showValidationMessage(cadena)
                        router.visit(route('saledocuments_list'), { replace: true });
                    }
                    return res
                });
            },
            allowOutsideClick: () => !Swal2.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                var cadena = "";
                let array = JSON.parse(result.value.data.notes);
                for (var i = 0; i < array.length; i++) {
                    cadena += array[i] + "<br>";
                }

                Swal2.fire({
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
</script>
<template>
    <AppLayout title="Punto de Ventas">
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Crear Documentos</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex-shrink max-w-full w-full mb-6">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-700 mb-3">
                        <div class="flex flex-col">
                            <div class="text-3xl font-bold mb-1">
                                <img style="width: 242px;height: 53.2333px;" class="inline-block h-auto ltr:mr-2 rtl:ml-2" :src="company.logo">
                            </div>
                            <p class="text-sm">Ancash, Chimbote<br>{{ company.fiscal_address }}</p>
                        </div>
                        <div style="width: 180px;" class="text-4xl uppercase font-bold">
                            <select @change="getSeriesByDocumentType" v-model="formDocument.sale_documenttype_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="(type, index) in saleDocumentTypes" :value="type.id"> {{  type.description  }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between py-2">
                        <div class="flex-1 pr-4 ">
                            <div class="grid grid-cols-3 gap-4 justify-between mb-1">
                                <div style="font-size: 14px;" class="col-span-3 sm:col-span-1 uppercase">Cliente:</div>
                                <div class="col-span-3 sm:col-span-2 ltr:text-right rtl:text-left">
                                    <input @click="openModalClientSearch" @input="openModalClientSearch" :value="formDocument.client_name" class="invoice-imput dark:text-gray-400 dark:bg-gray-700" type="text" />
                                    <SearchClients 
                                        :display="displayModalClientSearch" 
                                        :closeModalClient="closeModalClientSearch"
                                        @clientId="getDataClient" 
                                        :clientDefault="client" 
                                        :documentTypes="documentTypes"
                                        :saleDocumentTypes="saleDocumentTypesId"
                                        :ubigeo="departments"
                                    />
                                   <div><InputError :message="formDocument.errors.client_id" class="mt-2" /></div> 
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 justify-between mb-1">
                                <div style="font-size: 14px;" class="col-span-3 sm:col-span-1 uppercase">Ciudad:</div>
                                <div class="col-span-3 sm:col-span-2 ltr:text-right rtl:text-left">
                                    <input :value="formDocument.client_ubigeo_description" class="invoice-imput bg-gray-100 dark:text-gray-400 dark:bg-gray-700" disabled type="text" />
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 justify-between mb-1">
                                <div style="font-size: 14px;" class="col-span-3 sm:col-span-1 uppercase">Dirección:</div>
                                <div class="col-span-3 sm:col-span-2 ltr:text-right rtl:text-left">
                                    <input :value="formDocument.client_direction" class="invoice-imput bg-gray-100 dark:text-gray-400 dark:bg-gray-700" disabled type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between mb-1">
                                <div style="font-size: 14px;" class="flex-1 uppercase">Serie:</div>
                                <div class="flex-1 ltr:text-right rtl:text-left">
                                    <select v-model="formDocument.serie" class="invoice-select dark:text-gray-400 dark:bg-gray-700">
                                        <option v-for="(serie) in series" :value="serie.id" >{{ serie.description }}</option>
                                    </select>
                                    <InputError :message="formDocument.errors.serie" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex justify-between mb-1">
                                <div style="font-size: 14px;" class="flex-1 uppercase">Fecha de Emisión:</div>
                                <div class="flex-1 ltr:text-right rtl:text-left">
                                    <input v-model="formDocument.date_issue" class="invoice-imput dark:text-gray-400 dark:bg-gray-700" type="date" />
                                    <InputError :message="formDocument.errors.date_issue" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex justify-between mb-1">
                                <div style="font-size: 14px;" class="flex-1 uppercase">Fecha de vencimiento:</div>
                                <div class="flex-1 ltr:text-right rtl:text-left">
                                    <input v-model="formDocument.date_end" class="invoice-imput dark:text-gray-400 dark:bg-gray-700" type="date" />
                                    <InputError :message="formDocument.errors.date_end" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto py-2">
                        <table class="table-bordered w-full ltr:text-left rtl:text-right text-gray-600">
                            <thead class="border-b border-t border-gray-400 dark:border-gray-700">
                                <tr class="bg-gray-100 dark:bg-gray-900 dark:bg-opacity-20">
                                    <th style="width: 70px;" class="text-right py-1">
                                        <button @click="newItems" type="button" style="width: 28px;" title="Agregar Nuevo" class="mr-1 text-center  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-xs p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <font-awesome-icon :icon="faPlus" />
                                        </button>
                                        <button @click="displaySearchProducts = !displaySearchProducts" type="button" style="width: 28px;" title="Abrir Buscar" class="text-center  text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium text-xs p-2 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            <font-awesome-icon :icon="faMagnifyingGlass" />
                                        </button>
                                        <SearchProducts @eventdata="getDataTable" :displaySearch="displaySearchProducts" :close="closeSearchProducus" />
                                    </th>                                    
                                    <th class="text-left text-xs uppercase px-2 py-1">Item</th>
                                    <th class="text-center text-xs uppercase px-2 py-1">Producto</th>
                                    <th class="text-center text-xs uppercase px-2 py-1">Tipo de Unidad</th>
                                    <th class="text-center text-xs uppercase px-2 py-1">Cantidad</th>
                                    <th class="text-center text-xs uppercase px-2 py-1">Precio unitario</th>
                                    <th class="text-center text-xs uppercase px-2 py-1">Descuento</th>
                                    <th class="text-center text-xs uppercase px-2 py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="formDocument.items && formDocument.items.length > 0">
                                    <template v-for="(row, key) in formDocument.items">
                                        <tr>
                                            <td class="text-right" >
                                                <button @click="removeItem(key)" type="button" style="width: 28px;" class="text-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-xs p-2 text-center inline-flex items-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                    <font-awesome-icon :icon="faXmark"  />
                                                </button>
                                            </td>
                                            <td class="">
                                                <input v-model="row.description" 
                                                :disabled="row.id ? true : false" 
                                                :class="row.id ? 'bg-gray-100' : ''" 
                                                :ref="'item-description-' + key" 
                                                :style="row.id ? 'cursor: not-allowed': ''"
                                                class="invoice-imput text-left dark:text-gray-400 dark:bg-gray-700" type="text" />
                                            </td>
                                            <td style="width: 80px;" class="text-center">
                                                <input v-model="row.is_product" 
                                                :disabled="row.id ? true : false" 
                                                :class="row.id ? 'bg-gray-100' : ''" 
                                                :style="row.id ? 'cursor: not-allowed': ''"
                                                type="checkbox">
                                            </td>
                                            <td style="width: 110px;">
                                                <select v-model="row.unit_type" 
                                                :disabled="row.id ? true : false" 
                                                :class="row.id ? 'bg-gray-100' : ''" 
                                                :style="row.id ? 'cursor: not-allowed': ''"
                                                class="invoice-select dark:text-gray-400 dark:bg-gray-700">
                                                    <template v-for="(unitType) in unitTypes">
                                                        <option :value="unitType.id" >{{ unitType.description }}</option>
                                                    </template>
                                                </select>
                                            </td>
                                            <td style="width: 70px;" class="text-center">
                                                <input v-model="row.quantity" 
                                                @input="calculateTotals(key)" 
                                                :disabled="row.id ? true : false" 
                                                :class="row.id ? 'bg-gray-100' : ''" 
                                                :style="row.id ? 'cursor: not-allowed': ''"
                                                class="invoice-imput text-right dark:text-gray-400 dark:bg-gray-700" type="text" />
                                            </td>
                                            <td style="width: 120px;" class="text-right">
                                                <input v-model="row.unit_price" 
                                                @input="calculateTotals(key)" 
                                                :disabled="row.id ? true : false" 
                                                :style="row.id ? 'cursor: not-allowed': ''"
                                                :class="row.id ? 'bg-gray-100' : ''" 
                                                class="invoice-imput text-right dark:text-gray-400 dark:bg-gray-700" type="text" />
                                            </td>
                                            <td style="width: 90px;" class="text-right">
                                                <input v-model="row.discount" @input="calculateTotals(key)" 
                                                :disabled="row.id ? true : false" 
                                                :class="row.id ? 'bg-gray-100' : ''" 
                                                :style="row.id ? 'cursor: not-allowed': ''"
                                                class="invoice-imput text-right dark:text-gray-400 dark:bg-gray-700" type="text" />
                                            </td>
                                            <td style="width: 110px;" class="text-right ">
                                                <input v-model="row.total" 
                                                style="cursor: not-allowed"
                                                class="invoice-imput text-right bg-gray-100 dark:text-gray-400 dark:bg-gray-700" disabled type="text" />
                                                <InputError :message="formDocument.errors[`items.${key}.total`]" class="mt-2" />
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td colspan="8">
                                            <div class="flex items-center mt-1 p-2 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                                                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                                </svg>
                                                <span class="sr-only">Info</span>
                                                <div>
                                                    Click en <span class="p-1 bg-blue-700 text-white"><font-awesome-icon @click="newItems" :icon="faPlus" /></span> para agregar o click en <span class="p-1 bg-gray-700 text-white"><font-awesome-icon @click="displaySearchProducts = true" :icon="faMagnifyingGlass" /></span> para buscar producto o servicio
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="4" class="text-right text-xs uppercase"><b>OP. GRAVADAS: S/</b></td>
                                    <td class="text-right text-xs">{{ formDocument.total_taxed }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="4" class="text-right text-xs uppercase"><b>descuento: S/</b></td>
                                    <td class="text-right text-xs">{{ formDocument.total_discount  }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="4" class="text-right text-xs uppercase"><b>IGV: S/</b></td>
                                    <td class="text-right text-xs">{{ formDocument.total_igv }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="4" class="text-right text-xs uppercase"><b>TOTAL A PAGAR: S/</b></td>
                                    <td class="text-right font-bold text-xs">
                                        {{ formDocument.total }}
                                        <InputError :message="formDocument.errors.total" class="mt-2" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="max-w-full overflow-x-auto py-2">
                        <label style="font-size: 14px;" class="italic font-bold uppercase mb-4">Medio de Pago <button @click="addPayment()" type="button" class="inline-block px-0 py-2 bg-transparent text-blue-600 font-medium text-xs leading-tight uppercase rounded transition duration-150 ease-in-out">Agregar (+)</button></label>
                        <table class="table-bordered w-full ltr:text-left rtl:text-right text-gray-600">
                            <tbody>
                                <tr v-for="(row, index) in formDocument.payments" v-bind:key="index">
                                    <td style="width: 70px;" class="text-right">
                                        <button @click="removePayment(index)" type="button" style="width: 28px;" class="text-xs p-1.5 inline-block bg-red-700 text-white leading-normal uppercase shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                            <font-awesome-icon :icon="faXmark" />
                                        </button>
                                    </td>
                                    <td >
                                        <select v-model="row.type" class="invoice-select dark:text-gray-400 dark:bg-gray-700">
                                            <template v-for="(payment) in payments">
                                                <option :value="payment.id">{{ payment.description }}</option>
                                            </template>
                                        </select>
                                        <InputError :message="formDocument.errors[`payments.${index}.id`]" class="mt-2" />
                                    </td>
                                    <td>
                                        <input v-model="row.reference" type="text" id="first_name" class="invoice-imput text-left dark:text-gray-400 dark:bg-gray-700" placeholder="Referencia">
                                        <InputError :message="formDocument.errors[`payments.${index}.reference`]" class="mt-2" />
                                    </td>
                                    <td style="width: 110px;">
                                        <input v-model="row.amount" type="text" id="first_name" class="invoice-imput text-right dark:text-gray-400 dark:bg-gray-700" placeholder="Monto" required>
                                        <InputError :message="formDocument.errors[`payments.${index}.amount`]" class="mt-2" />
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="flex justify-end">
                        <SecondaryButton class="mr-2">
                            Cancelar
                        </SecondaryButton> 
                        <DangerButton @click="saveDocument" :class="{ 'opacity-25': formDocument.processing }" :disabled="formDocument.processing">
                            <svg v-show="formDocument.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                            </svg>
                            Generar
                        </DangerButton> 
                    </div>
                </div>
            </div>
        </div>
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
</style>