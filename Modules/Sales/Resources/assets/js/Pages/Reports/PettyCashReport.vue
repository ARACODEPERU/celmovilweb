
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Keypad from '@/Components/Keypad.vue';
import * as XLSX from 'xlsx/dist/xlsx.full.min';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';  
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    locals: {
        type: Object,
        default: () => ({}),
    },
    tickets: {
        type: Object,
        default: () => ({}),
    },
    physicals: {
        type: Object,
        default: () => ({}),
    },
    start:{
        type: String,
        default: null
    },
    end:{
        type: String,
        default: null
    },
    date:{
        type: String,
        default: null
    },
    petty_cash: {
        type: Object,
        default: () => ({}),
    },
    expenses: {
        type: Object,
        default: () => ({}),
    },
    total : {
        type: Number,
        default: 0,
    }
});

const form = useForm({
    local_id: props.petty_cash.local_sale_id,
});

const local_name = ref(null);

const  getLocal = (id = null) => {
    if(id){
        let arreglo = props.locals;
        let local = arreglo.find(arreglo => arreglo.id == id);
        local_name.value = local.description;
    } else{
        local_name.value = "TODOS LOS LOCALES"
    }
    
}
const getTotalQuantities = () => {
    let quantities=0;
    let arreglo = props.tickets;
    arreglo.forEach(sale => {
        quantities+=JSON.parse(sale.product).quantity;
    });
    return quantities;
}


const getTotalExpenses = () => {
    let expenses=0.0;
    props.expenses.forEach(expense=> {
        expenses+=parseFloat(expense.amount);
    });
    return expenses;
}

const downloadExcel = () => {
    const workbook = XLSX.utils.book_new();

    // Obtén la tabla HTML que deseas convertir
    const table = document.getElementById('table_export');

    // Convierte la tabla HTML en una hoja de cálculo
    const worksheet = XLSX.utils.table_to_sheet(table);
    worksheet['!cols'] = [
        {width:4}, // Columna "A" #
        {width:12}, // Columna "B" Fecha
        {width:30}, // Columna "C" Tienda
        {width:9}, // Columna "D" Cod. Prod.
        {width:35}, // Columna "E" Producto
        {width:12}, // Columna "F" Precio Vendido
        {width:9}, // Columna "G" Cantidad
        {width:9}, // Columna "H" Talla
        {width:9}, // Columna "I" Total
    ];

    XLSX.utils.book_append_sheet(workbook, worksheet, props.start+'-'+props.end);
    XLSX.writeFile(workbook, 'RpteCaja_'+local_name.value+"-"+props.start+'.xlsx');
}


const downloadPdf = () => {
    const table = document.getElementById('table_export');

    const pdf = new jsPDF({
        orientation: 'landscape',
        unit: 'pt',
        format: 'a4'
    });

    let titulo = "Reporte de Caja de: "+ local_name.value;
    pdf.text(titulo, 200, 20); //X e Y

    titulo="Día: "+ props.petty_cash.state == 0 ? props.petty_cash.date_opening : 'Caja abierta';
    
    pdf.text(titulo, 200, 40);
        // Genera la tabla PDF utilizando jsPDF
        pdf.autoTable({
        html: table,
        startY: 70  // altura(Y) desde top para iniciar dibujar la tabla
    });

    // Guarda el archivo PDF
    pdf.save('RpteCaja_'+ local_name.value + "-" + props.petty_cash.state == 0 ? props.petty_cash.date_opening : 'xx-xx-xxxx' +".pdf");
}

onMounted(()=>{
    getLocal();
    getTotalQuantities();
});
</script>

<template>
    <AppLayout title="Ventas en caja">
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
                            <Link :href="route('pettycash.index')" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Caja Chica</Link>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Reporte</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Breadcrumb End -->
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('pettycash.index'))">
                                    <select v-model="form.local_id" v-on:change="getReport()"
                                        id="stablishment"
                                        disabled
                                        class="w-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="0">Todos los Locales</option>
                                        <template v-for="(local, index) in props.locals" :key="index">
                                            <option :value="local.id">{{ local.description }}</option>
                                        </template>
                                    </select>
                                </form>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <Keypad>
                                    <template #botones>
                                        
                                        <button v-if="false" v-on:click="downloadExcel()"
                                            class="px-3 py-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            >Exportar en Excel
                                        </button>

                                        <button v-on:click="downloadPdf()"
                                            class="px-3 py-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            >Exportar en PDF
                                        </button>
                                        <a :href="route('pettycash.index')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</a>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table id="table_export" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th colspan="2" class="py-1 px-4 text-left font-medium text-black dark:text-white"><strong>LOCAL:</strong> </th>
                                    <th colspan="4" class="py-1 px-4 text-left font-medium text-black dark:text-white">{{ local_name }}</th>
                                </tr>
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th colspan="2" class="py-1 px-4 text-left font-medium text-black dark:text-white">
                                        <strong>Desde: </strong> 
                                    </th>
                                    <th colspan="4" class="py-1 px-4 text-left font-medium text-black dark:text-white">
                                        <span v-if="petty_cash.state == 0">
                                            {{ petty_cash.date_opening +" "+ petty_cash.time_opening.slice(0, -3) }}
                                        </span>
                                    </th>
                                </tr>
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th colspan="2" class="py-1 px-4 text-left font-medium text-black dark:text-white">
                                        <strong>HASTA: </strong> 
                                    </th>
                                    <th colspan="4" class="py-1 px-4 text-left font-medium text-black dark:text-white">
                                        <span v-if="petty_cash.state == 0">
                                            {{ petty_cash.date_closed +" "+ petty_cash.time_closed }}
                                        </span>
                                    </th>
                                </tr>
                                <tr class="bg-gray-50 border-b border-stroke text-left dark:bg-meta-4">
                                    <th colspan="2"  class="py-1 px-4 text-left font-medium text-black dark:text-white"><strong>Monto final en Caja:</strong></th>
                                    <th colspan="4"  class="py-1 px-4 text-left font-medium text-black dark:text-white">{{ petty_cash.final_balance }}</th>
                                </tr>
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th class="text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark" colspan="6">Ventas</th>
                                </tr>
                                <tr class="border border-stroke">
                                    <th scope="col" class="px-6 py-3">
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tienda
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Producto / Servicio
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Precio Vendido
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ticket, index) in tickets" :key="ticket.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ ticket.sale_date }}
                                    </th>
                                    <td class="px-2 py-2">
                                        {{ getLocal(ticket.local_id) }}
                                    </td>
                                    <td class="px-2 py-2">
                                        {{ ticket.interne + " - " + ticket.product_description }}
                                    </td>
                                    <td class="px-2 py-2">
                                        {{ JSON.parse(ticket.product).price }}
                                    </td>
                                    <td class="px-2 py-2">
                                        {{ JSON.parse(ticket.product).quantity }}
                                    </td>
                                    <td class="px-2 py-2">
                                        {{ JSON.parse(ticket.product).quantity * JSON.parse(ticket.product).price }}
                                    </td>
                                </tr>
                                <template v-for="(physical, key) in physicals">
                                    <tr v-for="(pro, k) in JSON.parse(physical.products)"  :key="pro.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ physical.sale_date }}
                                        </th>
                                        <td class="px-2 py-2">
                                            {{ physical.description }}
                                        </td>
                                        <td class="px-2 py-2">
                                            {{ pro.interne + " - " + pro.description }}
                                        </td>
                                        <td class="px-2 py-2 text-right">
                                            {{ pro.unit_price }}
                                        </td>
                                        <td class="px-2 py-2 text-right">
                                            {{ pro.quantity }}
                                        </td>
                                        <td class="px-2 py-2 text-right">
                                            {{ pro.total }}
                                        </td>
                                    </tr>
                                </template>
                                <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th colspan="5" class="text-right  px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Totales En Ventas</th>
                                    <th class="px-2 py-2 text-right ">S/ {{ total }}</th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <template v-if="expenses.length > 0">
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark" colspan="6">GASTOS</th>
                                    </tr>
                                    <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        
                                        <th scope="col" class="px-6 py-3">N° Documento</th>
                                        <th scope="col" colspan="4" class="px-6 py-3">Motivo o Descripción</th>
                                        <th scope="col" class="px-6 py-3">Monto</th>
                                    </tr>
                                    <tr v-for="(expense, index) in expenses" :key="expense.id" class="border border-stroke">  
                                        <td class="border border-stroke text-left text-sm py-2 px-2 text-black dark:text-white dark:border-strokedark">
                                            {{ expense.document }}
                                        </td>
                                        <td colspan="4" class="border border-stroke text-left text-sm py-2 px-2 text-black dark:text-white dark:border-strokedark">
                                            {{ expense.description }}
                                        </td>      
                                        <td class="border border-stroke text-right text-sm py-2 px-2 text-black dark:text-white dark:border-strokedark">
                                            {{ expense.amount }}
                                        </td>                          
                                    </tr>
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th colspan="5" class="border border-stroke text-right text-sm py-2 px-2 text-black dark:text-white dark:border-strokedark">Total en Gastos:</th>
                                        <th class="border border-stroke text-right text-sm py-2 px-2 text-black dark:text-white dark:border-strokedark">S/ {{ getTotalExpenses() }}</th>
                                    </tr>
                                </template>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
