
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { faTrashAlt, faPencilAlt, faPrint } from "@fortawesome/free-solid-svg-icons";

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

</script>


<script>
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var ano = fecha.getFullYear(); //obteniendo año
    if(dia<10)dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)mes='0'+mes //agrega cero si el menor de 10
    fecha=ano+"-"+mes+"-"+dia;

    export default {
        name: "Fechas",
        data: () => ({
            date_start: fecha,
            date_end: fecha,
            download: false
        })
    };
</script>


<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reportes
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="col-span-6 p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                        <div class="grid grid-cols-4 gap-3 py-2" id="form-dates">
                            <div>
                                <input type="date" v-model="date_start"
                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="f1" />
                            </div>
                            <div>
                                <input type="date" v-model="date_end"
                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="f2" />
                            </div>
                            <div class="" hidden>
                               <input type="checkbox" class="form-check-input" v-model="download"><label class="form-check-label">Descargar reportes</label>
                            </div>

                            <div class="text-right">
                                <ModalCashCreate :locals="locals" />
                            </div>
                        </div>

                    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-4">

                        <div class="p-6">
                            <a :href="route('inventory_report_export',[download])" type="button" target="_blank"
                                class=" w-full inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-yellow-600 hover:shadow-lg focus:bg-yellow-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-yellow-700 active:shadow-lg transition duration-150 ease-in-out">
                                Reporte de Inventario
                            </a>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </AppLayout>
</template>
