<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import Keypad from '@/Components/Keypad.vue';
    import TextInput from '@/Components/TextInput.vue';
    import swal from "sweetalert";

    const props = defineProps({
        locals: {
            type: Object,
            default: () => ({}),
        },
    });

    const form = useForm({
        local_id: 0,
        start: new Date().toISOString().substr(0, 10),
        end: new Date().toISOString().substr(0, 10)
    });

    const formData = useForm({
        payments:[],
        total:0
    });

    const getTotals = () => {
        if (form.start && form.end && form.start > form.end) {
            swal('La fecha de inicio no puede ser mayor a la fecha de término');
        } else {
            axios.post(route('data_payment_method_totals'), form ).then((res) => {
                if(Object.entries(res).length > 0){
                    formData.payments   = res.data.payments;
                    formData.total      = res.data.total;
                } else {
                    swal('No se encontró producto');
                }
            });
        }
    }
</script>
<template>
    <AppLayout title="Reporte">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reporte Totales de método de pago
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="col-span-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="grid grid-cols-6 pt-4 pl-4 pr-4 items-center">
                        <div class="col-span-6 p-2 sm:col-span-2">
                            <select @change="getTotals()" v-model="form.local_id" id="stablishment" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">Seleccionar Tienda</option> 
                                <template v-for="(establishment, index) in props.locals" :key="index">
                                    <option :value="establishment.id">{{ establishment.description }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-span-6 p-2 sm:col-span-1">
                            <TextInput
                                id="start"
                                v-model="form.start"
                                type="date"
                                class="block w-full mt-1"
                                @change="getTotals()"
                            />
                        </div>
                        <div class="col-span-6 p-2 sm:col-span-1">
                            <TextInput
                                id="end"
                                v-model="form.end"
                                type="date"
                                class="block w-full mt-1"
                                @change="getTotals()"
                            />
                        </div>
                        <div class="col-span-6 p-2 sm:col-span-2 text-right">
                            <Keypad>
                                <!-- <template #botones>
                                    <a :href="route('users.create')" class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Exportar PDF</a>
                                </template> -->
                            </Keypad>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div v-for="(method, index) in formData.payments" class="w-full md:w-1/2 xl:w-1/3 p-6">
                            <!--Metric Card-->
                            <div 
                                class="bg-gradient-to-b border-b-4 rounded-lg shadow-xl p-5"
                                :class="{
                                    'from-green-200 to-green-100 border-green-600': method.id === 1,
                                    'from-indigo-200 to-indigo-100 border-indigo-600': method.id === 2,
                                    'from-purple-200 to-purple-100 border-purple-400': method.id === 3,
                                    'from-yellow-200 to-yellow-100 border-yellow-600': method.id === 4,
                                    'from-yellow-200 to-yellow-100 border-yellow-900': method.id === 5,
                                    'from-purple-200 to-purple-100 border-purple-900': method.id === 6,
                                    'from-pink-200 to-pink-100 border-pink-600': method.id === 7,
                                    'bg-gray-200 border-gray-600': true
                                }"
                                >
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-1">
                                        <div class="">
                                            <img v-if="method.id == 1" src="/bancos_logos/efectivo.jpg" style="width: 74px;height: 74px;" class="rounded-full" />
                                            <img v-else-if="method.id == 2" src="/bancos_logos/yape.png" style="width: 74px;height: 74px;" class="rounded-full" />
                                            <img v-else-if="method.id == 3" src="/bancos_logos/plin.png" style="width: 74px;height: 74px;" class="rounded-full" />
                                            <img v-else-if="method.id == 4" src="/bancos_logos/bcp.jpg" style="width: 74px;height: 74px;" class="rounded-full" />
                                            <img v-else-if="method.id == 5" src="/bancos_logos/interbank.png" style="width: 74px;height: 74px;" class="rounded-full" />
                                            <img v-else-if="method.id == 6" src="/bancos_logos/visa.jpg" style="width: 74px;height: 74px;" class="rounded-full" />
                                            <img v-else src="/bancos_logos/default.jpg" style="width: 74px;height: 74px;" class="rounded-full" />
                                        </div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600">{{ method.description }}</h2>
                                        <p class="font-bold text-3xl">S/. {{ method.amount }}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/Metric Card-->
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class=" text-center py-4 lg:px-4 ml-auto">
                            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex rounded-full" role="alert">
                                <span class="flex bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3 rounded-full">TOTAL:</span>
                                <span class="font-semibold mr-2 text-left flex-auto">{{ formData.total.toLocaleString('es-PE', { style: 'currency', currency: 'PEN', minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>