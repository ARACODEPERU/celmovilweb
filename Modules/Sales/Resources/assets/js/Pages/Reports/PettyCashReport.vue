
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import * as XLSX from 'xlsx/dist/xlsx.full.min';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';   //No lo borres si se usa aunque pareciera que no.
import Keypad from '@/Components/Keypad.vue';

const props = defineProps({
    locals: {
        type: Object,
        default: () => ({}),
    },
    sales: {
        type: Object,
        default: () => ({}),
    },
    start: {
        type: Object,
        default: () => ({}),
    },
    end: {
        type: Object,
        default: () => ({}),
    },
    petty_cash: {
        type: Object,
        default: () => ({}),
    },
    expenses: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    start:props.start,
    end:props.end,
    local_id:props.petty_cash.local_sale_id,
    sales:props.sales,
    expenses:props.expenses,
    local_name:"TODOS LOS LOCALES"
});

function getLocal(id){
    let arreglo = props.locals;
    let local = arreglo.find(arreglo => arreglo.id == id);
    return local.description;
}

function getTotalQuantities(){
    let quantities=0;
    let arreglo = form.sales;
    arreglo.forEach(sale=> {
        quantities+=JSON.parse(sale.product).quantity;
    });
    return quantities;
}
function getTotalPrices(){
    let prices=0;
    form.sales.forEach(sale=> {
        prices+=JSON.parse(sale.product).quantity*JSON.parse(sale.product).price;
    });
    return prices;
}
function getTotalExpenses(){
    let expenses=0.0;
    form.expenses.forEach(expense=> {
        expenses+=parseFloat(expense.amount);
    });
    return expenses;
}
getReport();
function getReport(){

    getTotalPrices();
    getTotalQuantities();


  props.locals.forEach(local => {
    if(form.local_id == local.id){
        form.local_name = local.description;
    }
    if(form.local_id == 0)form.local_name= "TODOS LOS LOCALES";
  });
}

// const botonImprimir = document.getElementById('boton-imprimir');
// botonImprimir.addEventListener('click', () => {
//   window.print();
// });

function downloadExcel(){
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

XLSX.utils.book_append_sheet(workbook, worksheet, form.start+'-'+form.end);
XLSX.writeFile(workbook, 'RpteCaja_'+form.local_name+"-"+form.start+'.xlsx');
}


function downloadPdf(){
    const table = document.getElementById('table_export');

    const pdf = new jsPDF({
    orientation: 'landscape',
    unit: 'pt',
    format: 'a4'
    });
    let titulo = "Reporte de Caja de: "+form.local_name;
    pdf.text(titulo, 200, 20); //X e Y
    titulo="Día: "+props.petty_cash.date_opening;
    pdf.text(titulo, 200, 40);
        // Genera la tabla PDF utilizando jsPDF
        pdf.autoTable({
        html: table,
        startY: 70  // altura(Y) desde top para iniciar dibujar la tabla
        });

    // Guarda el archivo PDF
    pdf.save('RpteCaja_'+form.local_name+"-"+props.petty_cash.date_opening+".pdf");
}
</script>

<template>
    <AppLayout title="Ventas en caja">
        <div class="max-w-screen-2xl  mx-auto p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <nav class="flex px-4 py-3 border border-stroke text-gray-700 mb-4 bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Inicio
                        </a>
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
            <!-- Breadcrumb End -->
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white px-5  pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('pettycash.index'))">
                                    <InputLabel for="stablishment" value="Establecimiento" />
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
                    <div class="max-w-full overflow-x-auto">
                        <div id="ContenidoTabla">
                            <table id="table_export" class="w-full table-auto">
                                <thead class="border-b border-stroke">
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th colspan="9" class="py-1 px-4 text-center font-medium text-black dark:text-white">
                                            <strong>Matos Store - Ventas Caja</strong>
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th colspan="2" class="py-1 px-4 text-left font-medium text-black dark:text-white">
                                            <strong>Desde: </strong> 
                                        </th>
                                        <th colspan="7" class="py-1 px-4 text-left font-medium text-black dark:text-white">
                                            {{ props.petty_cash.date_opening +" "+ props.petty_cash.time_opening.slice(0, -3) }} <strong>cerrado  el:</strong> {{ props.petty_cash.date_closed +" "+ props.petty_cash.time_closed.slice(0, -3) }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th colspan="2" class="py-1 px-4 text-left font-medium text-black dark:text-white"><strong>De:</strong> </th>
                                        <th colspan="7" class="py-1 px-4 text-left font-medium text-black dark:text-white">{{ form.local_name }}</th>
                                    </tr>
                                    <tr class="bg-gray-50 border-b border-stroke text-left dark:bg-meta-4">
                                        <th colspan="2"  class="py-1 px-4 text-left font-medium text-black dark:text-white"><strong>Monto final en Caja:</strong></th>
                                        <th colspan="7"  class="py-1 px-4 text-left font-medium text-black dark:text-white">{{ props.petty_cash.final_balance }}</th>
                                    </tr>

                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                        #
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Fecha
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Tienda
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Cod. Prod.
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Producto
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Precio Vendido
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Cantidad
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Talla
                                        </th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            Total
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(sale, index) in form.sales" :key="sale.id" :class="  index % 2 == 0 ? 'bg-gray-100 hover:bg-gray-300 border-b' : 'bg-gray-200 hover:bg-gray-300 border-b'">
                                        <td class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ sale.created_at }}
                                        </td>
                                        <td class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ getLocal(sale.local_id) }}
                                        </td>
                                        <td class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ sale.interne }}
                                        </td>
                                        <td class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            <img :src="'/storage/'+sale.image" width="40"> {{ sale.product_description }}
                                        </td>
                                        <td class="border border-stroke text-right  text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ JSON.parse(sale.product).price }}
                                        </td>
                                        <td class="border border-stroke text-right  text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ JSON.parse(sale.product).quantity }}
                                        </td>
                                        <td class="border border-stroke text-right  text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ JSON.parse(sale.product).size }}
                                        </td>
                                        <td class="border border-stroke text-right  text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ JSON.parse(sale.product).quantity * JSON.parse(sale.product).price }}
                                        </td>
                                    </tr>

                                </tbody>

                                <tfoot>
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th colspan="6" class="border border-stroke text-right text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">Totales</th>
                                        <th class="border border-stroke text-right  text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">{{ getTotalQuantities()}}</th>
                                        <th class="border border-stroke text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark"></th>
                                        <th class="border border-stroke text-right  text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">S/ {{ getTotalPrices()}}</th>
                                    </tr>
                                    <template v-if="expenses.length > 0">
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark" colspan="9">GASTOS</th>
                                    </tr>
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th class="border border-stroke text-center text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">#</th>
                                        <th class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">N° Documento</th>
                                        <th colspan="6" class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">Motivo o Descripción</th>
                                        <th class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">Monto</th>
                                    </tr>
                                    <tr  v-for="(expense, index) in form.expenses" :key="expense.id" :class="  index % 2 == 0 ? 'bg-gray-100 hover:bg-gray-300 border-b' : 'bg-gray-200 hover:bg-gray-300 border-b'">  
                                        <td class="border border-stroke text-center text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">{{ index + 1 }}</td>
                                        <td class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ expense.document }}
                                        </td>
                                        <td colspan="6" class="border border-stroke text-left text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ expense.description }}
                                        </td>      
                                        <td class="border border-stroke text-right text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">
                                            {{ expense.amount }}
                                        </td>                          
                                    </tr>
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th colspan="8" class="border border-stroke text-right text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">Total en Gastos:</th>
                                        <th class="border border-stroke text-right text-sm py-2 px-4 text-black dark:text-white dark:border-strokedark">S/ {{ getTotalExpenses() }}</th>
                                    </tr>
                                    </template>
                                </tfoot>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
