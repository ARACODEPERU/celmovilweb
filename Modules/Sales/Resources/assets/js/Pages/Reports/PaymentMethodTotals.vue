<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import Keypad from '@/Components/Keypad.vue';
import TextInput from '@/Components/TextInput.vue';
import swal from "sweetalert";
import { ref } from 'vue'
import { 
    List, ListItem, Skeleton, ListItemMeta, Avatar
} from 'ant-design-vue';

const refLoading = ref(false);

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
    refLoading.value = true;
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
            refLoading.value = false;
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
                                <template #botones>
                                    <Link :href="route('reports')" class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                                </template>
                            </Keypad>
                        </div>
                    </div>
                    <div class="mt-4">
                        
                        <div class="border-t border-stroke ">
                            <List
                                class="demo-loadmore-list"
                                item-layout="horizontal"
                                :data-source="formData.payments"
                            >
                                <template #renderItem="{ item }">
                                <ListItem>
                                    <template #actions>
                                        S/. {{ item.amount }}
                                    </template>
                                    <Skeleton avatar :title="false" :loading="refLoading" active>
                                        <ListItemMeta >
                                            <template #title>
                                                {{ item.description }}
                                            </template>
                                            <template #avatar>
                                                <Avatar v-if="item.id == 1" src="/bancos_logos/efectivo.jpg" />
                                                <Avatar v-else-if="item.id == 2" src="/bancos_logos/yape.png" />
                                                <Avatar v-else-if="item.id == 3" src="/bancos_logos/plin.png" />
                                                <Avatar v-else-if="item.id == 4" src="/bancos_logos/bcp.jpg" />
                                                <Avatar v-else-if="item.id == 5" src="/bancos_logos/interbank.png" />
                                                <Avatar v-else-if="item.id == 6" src="/bancos_logos/visa.jpg" />
                                                <Avatar v-else src="/bancos_logos/default.jpg" />
                                            </template>
                                        </ListItemMeta>
                                        <div>Monto</div>
                                    </Skeleton>
                                </ListItem>
                                </template>
                                <template #footer>
                                    <div class="flex flex-wrap">
                                        <div class="text-center ml-auto">
                                            <div class="bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex rounded-full" role="alert">
                                                <span class="flex bg-indigo-500 text-white uppercase px-2 py-1 text-xs font-bold mr-3 rounded-full">TOTAL:</span>
                                                <span class="font-semibold mr-4 text-left flex-auto">{{ formData.total.toLocaleString('es-PE', { style: 'currency', currency: 'PEN', minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </List>
                        </div>

                        
                    </div>
                    
                </div>
            </div>
        </div>
    </AppLayout>
</template>