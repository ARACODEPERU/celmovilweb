
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import * as XLSX from 'xlsx/dist/xlsx.full.min';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';  //No lo borres si se usa aunque pareciera que no.
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

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
    payments:{
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    start:props.start,
    end:props.end,
    local_id:0,
    sales:props.sales,
    local_name:"TODOS LOS LOCALES",
    payments: props.payments
});

const totalPrice = ref(0);
const totalQuantity = ref(0);
const totalDiscount = ref(0);
const totalFinal = ref(0);

onMounted(() => {
    calculateTotals();
});

function calculateTotals() {
    totalPrice.value    = 0;
    totalQuantity.value = 0;
    totalDiscount.value = 0;
    totalFinal.value    = 0;
    form.sales.forEach(sale => {
        totalPrice.value      = totalPrice.value     + parseFloat(JSON.parse(sale.product).price);
        totalQuantity.value   = totalQuantity.value + parseFloat(JSON.parse(sale.product).quantity);
        totalDiscount.value   = totalDiscount.value + parseFloat(JSON.parse(sale.product).discount);
        totalFinal.value      = totalFinal.value + (parseFloat(JSON.parse(sale.product).price)*parseFloat(JSON.parse(sale.product).quantity))-parseFloat(JSON.parse(sale.product).discount);
    });
    
}


function getReport(){
    let url = route('sales_report_dates', {
        start: form.start,
        end: form.end,
        local_id: form.local_id,
        consulta:true
    });
    axios.get(url).then(response => {
        form.sales=null;
        form.sales = response.data.sales;
        form.payments = response.data.payments;
        calculateTotals();
    }).catch(err => {
        console.log("ERROR ENCONTRADO", err);
    });

    props.locals.forEach(local => {
        if(form.local_id == local.id){
            form.local_name = local.description;
        }
        if(form.local_id == 0)form.local_name= "TODOS LOS LOCALES";
    });
}


function downloadExcel(){
    const workbook = XLSX.utils.book_new();

    // Obtén la tabla HTML que deseas convertir
    const table = document.getElementById('table_export');

    // Convierte la tabla HTML en una hoja de cálculo
    const worksheet = XLSX.utils.table_to_sheet(table);
    worksheet['!cols'] = [
        {width:12}, // Columna "A" Fecha
        { width: 25 }, // Columna "B" Tienda
        {width:9}, // Columna "C" Cod. Prod.
        { width: 30 }, // Columna "D" Producto
        {width: 35}, //metodos de pago
        {width:12}, // Columna "F" Precio Vendido
        {width:9}, // Columna "G" Cantidad
        {width:9}, // Columna "H" Talla
        {width:9}, // Columna "I" Total
    ];

    XLSX.utils.book_append_sheet(workbook, worksheet, form.start+'-'+form.end);
    XLSX.writeFile(workbook, 'RpteVentas'+form.start+'-'+form.end+'.xlsx');
}


function downloadPdf(){
    const table = document.getElementById('table_export');

    const pdf = new jsPDF({
        orientation: 'landscape',
        unit: 'pt',
        format: 'a4'
    });
    let titulo = "Reporte de Ventas de: "+form.local_name;
    pdf.text(titulo, 200, 20); //X e Y
    titulo="Día: "+form.start;
    pdf.text(titulo, 200, 40);
    titulo="al: "+form.end;
    pdf.text(titulo, 400, 40);
        // Genera la tabla PDF utilizando jsPDF
    pdf.autoTable({
        html: table,
        startY: 70  // altura desde top para inicar dibujar la tabla
    });


    // Guarda el archivo PDF
    pdf.save('RpteVentas_'+form.local_name+'_'+form.start+'-'+form.end+'.pdf');
}

</script>

<template>
    <AppLayout title="Reportes de Ventas">
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
                            <Link :href="route('reports')" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Reportes</Link>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Reporte de ventas entre fechas(por locales)</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-6 gap-3 py-2">
                            <div class="col-span-6 sm:col-span-2">
                                <InputLabel for="stablishment" value="Establecimiento" />
                                <select v-model="form.local_id" v-on:change="getReport()"
                                    id="stablishment"
                                    class="w-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="0">Todos los Locales</option>
                                    <template v-for="(local, index) in props.locals" :key="index">
                                        <option :value="local.id">{{ local.description }}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-1">
                                <input type="date" v-model="form.start" v-on:change="getReport()"
                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    id="f1" />
                            </div>
                            <div class="col-span-6 sm:col-span-1">
                                <input type="date" v-model="form.end" v-on:change="getReport()"
                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    id="f2" />
                            </div>
                            <div v-if="false" class="col-span-6 sm:col-span-1">
                                <button v-on:click="downloadExcel()"
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none dark:bg-gray-700 "
                                        >Exportar en Excel
                                </button>
                            </div>

                            <div class="col-span-6 sm:col-span-1">
                                <button v-on:click="downloadPdf()"
                                class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    >Exportar en PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ContenidoTabla" class="max-w-full overflow-x-auto">
                        <table id="table_export" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead>
                                <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" v-if="form.start==form.end">
                                    <th colspan="10" scope="col" class="px-2 py-2 bg-gray-50 dark:bg-gray-800" style="text-align: center">Ventas del día: {{ form.start }} </th>
                                </tr>
                                <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" v-else>
                                    <th colspan="10" scope="col" class="px-2 py-2 bg-gray-50 dark:bg-gray-800" style="text-align: center">Matos Store - Ventas del: {{ form.start }} al {{ form.end }}</th>
                                </tr>
                                <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <th colspan="10" scope="col" class="px-2 py-2 bg-gray-50 dark:bg-gray-800" style="text-align: center">De: {{ form.local_name }}</th>
                                </tr>
                                <tr class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                    <th scope="col" class="px-2 py-2 text-center dark:bg-gray-700">
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-2 py-2 dark:bg-gray-700">
                                        Tienda
                                    </th>
                                    <th scope="col"  class="px-2 py-2 text-center dark:bg-gray-700">
                                        Cod. Prod.
                                    </th>
                                    <th scope="col" class="px-2 py-2 text-center dark:bg-gray-700">
                                        Talla
                                    </th>
                                    <th scope="col"  class="px-2 py-2 dark:bg-gray-700">
                                        Producto
                                    </th>
                                    <th scope="col" class="px-62 py-2 text-center bg-gray-50 dark:bg-gray-800">
                                        Metodos de Pago
                                    </th>
                                    <th scope="col" class="px-2 py-2 text-center dark:bg-gray-700">
                                        Precio Vendido
                                    </th>
                                    <th scope="col" class="px-2 py-2 text-center dark:bg-gray-700">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-2 py-2 text-center dark:bg-gray-700">
                                        Descuento
                                    </th>
                                    
                                    <th scope="col" class="px-2 py-2 text-center dark:bg-gray-700">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sale, index) in form.sales" :key="sale.id" :class="  index % 2 == 0 ? 'bg-gray-100 hover:bg-gray-300 border-b' : 'bg-gray-200 hover:bg-gray-300'" class="border-b border-stroke">
                                    <td class="px-2 py-2 text-center dark:bg-gray-600">
                                        {{ sale.created_at }}
                                    </td>
                                    <td class="px-2 py-2 dark:bg-gray-600">
                                        {{ sale.local_description }}
                                    </td>
                                    <td class="px-2 py-2 dark:bg-gray-600">
                                        {{ sale.interne }}
                                    </td>
                                    <td class="px-2 py-2 text-right dark:bg-gray-600">
                                        {{ JSON.parse(sale.product).size }}
                                    </td>
                                    <td class="px-2 py-2 text-center dark:bg-gray-600">
                                        <img :src="'/storage/'+sale.image" width="40"> {{ sale.product_description }}
                                    </td>
                                    <td rowspan="col" class="px-2 py-2 bg-gray-50 dark:bg-gray-700">
                                        <div v-for="pay in JSON.parse(sale.payments)"> 
                                            <ul class="">
                                                <li>
                                                    <span v-for="mto in form.payments">
                                                        <strong v-if="pay.type == mto.id">
                                                            Metodo: {{ mto.description }}
                                                        </strong>
                                                    </span>
                                                </li>
                                                <li>Referencia: {{ pay.reference }}</li>
                                                <li>Importe: {{ pay.amount }}</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-right dark:bg-gray-600">
                                        {{ JSON.parse(sale.product).price }}
                                    </td>
                                    <td class="px-2 py-2 text-right dark:bg-gray-600">
                                        {{ JSON.parse(sale.product).quantity }}
                                    </td>
                                    <td class="px-2 py-2 text-right dark:bg-gray-600">
                                        {{ JSON.parse(sale.product).discount }}
                                    </td>
                                    
                                    <td class="px-6 py-2 text-right dark:bg-gray-600">
                                        {{ sale.product_total }}
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr class="bg-blue-400 hover:bg-blue-600">
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-800" style="text-align: right" colspan="6">Totales</th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-800" style="text-align: right">S/ {{ totalPrice.toFixed(2) }}</th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-800" style="text-align: right">{{ totalQuantity }}</th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-800" style="text-align: right"> S/ {{ totalDiscount.toFixed(2) }} </th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-800" style="text-align: right">S/ {{ totalFinal.toFixed(2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
