<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SearchProducts from './Partials/SearchProducts.vue';
    import SearchClients from './Partials/SearchClients.vue';
    import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import Keypad from '@/Components/Keypad.vue';
    import Swal2 from 'sweetalert2';
    import { Link } from '@inertiajs/vue3';

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
        }
    });

    const form = useForm({
        products: [],
        total: 0,
        payments: [{
            type:1,
            reference: null,
            amount:0
        }],
        client:{
            id: props.client.id,
            full_name: props.client.full_name
        }
    });

    const getDataTable = async (data) => {
        let xtotal = parseFloat(data.total) + parseFloat(form.total);
        form.total = xtotal.toFixed(2);
        form.products.push(data);
        form.payments[0].amount = form.total;
    }

    const removeProduct = (key) => {
        let t = parseFloat(form.products[key].total);
        form.total = parseFloat(form.total) - t;
        form.products.splice(key,1);
    }

    const addPayment = () => {
        let ar = {
            type:1,
            reference: null,
            amount:0
        };
        form.payments.push(ar);
    };
    const removePayment = (index) => {
        if(index>0){
            form.payments.splice(index,1);
        }
    };
    const saveSale = async () => {
        Swal2.fire({
          imageUrl: '/img/loading-70.gif',
          imageHeight: 120,
          imageAlt: 'Cargando',
          showConfirmButton: false,
          allowOutsideClick: false
        });
        if(form.total>0){
            axios.post(route('sales.store'), form ).then((res) => {
                form.reset();
                Swal2.fire({
                    title: 'Ticket',
                    text: "¿Desea imprimir el ticket?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Imprimir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        printPdf(res.data.id);
                    }
                });
            }).catch((error) => {
                let validationErrors = error.response.data.errors;
                if (validationErrors && validationErrors.payments) {
                    const paymentsErrors = validationErrors.payments;
                    for (let i = 0; i < paymentsErrors.length; i++) {
                        form.setError('payments.'+index+'.amount', paymentsErrors[i]);
                    }
                }
                
                Swal2.close();
            });
        }else{
            swal('Agregar Productos para realizar la venta');
        }
        
    }

    const printPdf = (id) => {
        //window.location.href = "../../pdf/sales/ticket/" + id;
        let url = route('ticketpdf_sales',id)
        window.open(url, "_blank");
    }

    const getClient = async (data) => {
        form.client.id = data.id;
        form.client.full_name = data.full_name;
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ventas</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">punto de Ventas</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-2 gap-9">
                <div class="mb-2 pr-4 col-span-2 gap-9 sm:col-span-1">
                    <div class="p-2 border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <SearchProducts @eventdata="getDataTable" />
                        <div class="mt-4 relative overflow-x-auto">
                            <table class="border border-stroke w-full">
                                <thead class="border-b bg-gray-100 border-stroke dark:bg-gray-700">
                                    <tr>
                                        <th class="text-sm font-medium  px-2 py-2"></th>
                                        <th scope="col" class="text-sm font-medium px-6 py-2">
                                            Código & Descripción
                                        </th>
                                        <th class="text-sm font-medium px-2 py-2">
                                            Cantidad
                                        </th>
                                        <th class="text-sm font-medium  px-2 py-2">
                                            Precio
                                        </th>
                                        <th class="text-sm font-medium px-2 py-2">
                                            Descuento
                                        </th>
                                        <th class="text-sm font-medium px-2 py-2">
                                            Importe
                                        </th>
                                    </tr>
                                </thead >
                                <tbody style="max-height: 250px;overflow-y: auto;overflow-x: hidden;">
                                   <template v-if="form.products.length > 0">
                                    <tr v-for="(product, key) in form.products" class="border-b bg-gray-500 border-stroke">
                                        <td class="text-center text-sm text-white font-medium px-2 py-2">
                                            <div class="relative">
                                                <button @click="removeProduct(key)" type="button" class="inline-block rounded-full bg-blue-600 text-white leading-normal uppercase shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out px-3 py-2">
                                                    <font-awesome-icon :icon="faTrashAlt" />
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-sm text-white font-medium px-2 py-2">
                                            {{ product.interne  }} - {{ product.description  }}  {{ product.size ? '/' + product.size : ''  }}
                                        </td>
                                        <td class="text-right text-sm text-white font-medium px-2 py-2">
                                            {{ product.quantity  }}
                                        </td>
                                        <td class="text-right text-sm text-white font-medium px-2 py-2">
                                            {{ product.price  }}
                                        </td>
                                        <td class="text-right text-sm text-white font-medium px-2 py-2">
                                            {{ product.discount  }}
                                        </td>
                                        <td class="text-right text-sm text-white font-medium px-2 py-2">
                                            {{ product.total  }}
                                        </td>
                                    </tr>
                                   </template>
                                   <template v-else>
                                        <tr class="border-b border-stroke">
                                           <td colspan="6" class="text-center text-sm font-medium px-6 py-2">
                                                <div class="flex p-4 text-sm border border-gray-300 bg-gray-50 dark:bg-gray-800 dark:text-white dark:border-yellow-800" role="alert">
                                                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                    <span class="sr-only">Info</span>
                                                    <div>
                                                        <span class="font-medium">Vacío!</span> Agregar productos
                                                    </div>
                                                </div>
                                           </td> 
                                        </tr>
                                   </template>
                                </tbody>
                                <tfoot>
                                    <tr class="border-b bg-gray-100 border-stroke dark:bg-gray-700">
                                        <th colspan="5" class="text-right text-sm  font-medium px-2 py-2 whitespace-nowrap dark:text-white "><strong>Total a Cobrar</strong></th>
                                        <td class="text-right text-sm font-medium px-2 py-2 whitespace-nowrap dark:text-white "><strong>S/. {{ form.total }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mb-2 pr-4 col-span-2 gap-9 sm:col-span-1">
                    <div class="p-2 border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <SearchClients @clientId="getClient" :clientDefault="form.client" :documentTypes="documentTypes" />
                        <InputError :message="form.errors[`client.id`]" class="mt-2" />
                        <div class="mt-4">
                            <h4 class="italic font-bold mb-4">Medio de Pago</h4>
                            <table>
                                <tbody>
                                    <tr v-for="(row, index) in form.payments" v-bind:key="index">
                                        <td>
                                            <select v-model="row.type" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <template v-for="(payment) in payments">
                                                    <option :value="payment.id">{{ payment.description }}</option>
                                                </template>
                                            </select>
                                            <InputError :message="form.errors[`payments.${index}.id`]" class="mt-2" />
                                        </td>
                                        <td>
                                            <input v-model="row.reference" type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Referencia" required>
                                            <InputError :message="form.errors[`payments.${index}.reference`]" class="mt-2" />
                                        </td>
                                        <td>
                                            <input v-model="row.amount" type="text" id="first_name" class="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Monto" required>
                                            <InputError :message="form.errors[`payments.${index}.amount`]" class="mt-2" />
                                        </td>
                                        <td>
                                            <button @click="removePayment(index)" type="button" class="px-2 py-1 inline-block rounded-full bg-blue-600 text-white leading-normal uppercase shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                                <font-awesome-icon :icon="faTrashAlt" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button @click="addPayment()" type="button" class="inline-block px-0 py-2 bg-transparent text-blue-600 font-medium text-xs leading-tight uppercase rounded transition duration-150 ease-in-out">Agregar (+)</button>
                        </div>
                        <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 text-right">
                                <Keypad>
                                    <template #botones>
                                        <button @click="saveSale()" type="button" class=" inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">
                                            Cobrar
                                        </button>
                                        <Link :href="route('sales.index')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
