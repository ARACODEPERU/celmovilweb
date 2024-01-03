<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link,useForm, router } from '@inertiajs/vue3';
import Keypad from '@/Components/Keypad.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { 
    ConfigProvider, 
    Select,
    Card, 
    CardGrid, 
    Tabs, 
    TabPane, 
    Popover, 
    Table, 
    Button, 
    Flex, 
    Tooltip, 
    InputNumber,
    Input,
    Popconfirm,
    message
 } from 'ant-design-vue';
import { faFaceSmile } from "@fortawesome/free-solid-svg-icons";
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { ref, watch, onMounted } from 'vue';
import { faXmark, faPen, faDollarSign, faTimes } from "@fortawesome/free-solid-svg-icons";
import esES from 'ant-design-vue/es/locale/es_ES';

const props = defineProps({
    paymentMethods: {
        type: Object,
        default: () => ({}),
    },
    clients: {
        type: Object,
        default: () => ({}),
    },
    comandas: {
        type: Object,
        default: () => ({}),
    }
});

const activeKey = ref('0');
const comandasData= ref([]);

const filterOption = (input, option) => {
    const inputValueLower = input.toLowerCase();
    const optionTitleLower = option.label.toLowerCase();
    return optionTitleLower.includes(inputValueLower);
};

const getComandas = (comandas) => {
    comandasData.value = []
    let arrayData = [];
    if(comandas && comandas.length > 0){
        for(let i = 0; i < comandas.length; i++){
            arrayData.push({
                id: comandas[i].id,
                name: comandas[i].name,
                description: comandas[i].description,
                image: comandas[i].image,
                price: comandas[i].price,
                presentation: comandas[i].presentation
            });
        }
    }
    comandasData.value = arrayData;
}

watch(activeKey, (value) => {
    let array =  props.comandas[value];
    comandasData.value = array.comandas;
});

onMounted(() => {
    comandasData.value = props.comandas[0].comandas
});

const xhttp =  assetUrl;

const columns = [
    {
        title: 'operation',
        dataIndex: 'operation',
    },
    {
        title: 'Nombre',
        dataIndex: 'name',
        key: 'name'
    },
    {
        title: 'Precio',
        dataIndex: 'price',
        key: 'price'
    },
    {
        title: 'Cantidad',
        dataIndex: 'quantity',
        key: 'quantity'
    },
    {
        title: 'Total',
        dataIndex: 'total',
        key: 'total'
    },
    
]

const form = useForm({
    client_id: 1,
    total: 0,
    comandas: [],
    payments: [{
        type:1,
        reference: null,
        amount: 0
    }]
});

const addComanda = (comanda) => {
    form.comandas.push({
        id: comanda.id,
        name: comanda.name,
        description: comanda.description,
        image: comanda.image,
        presentation: comanda.presentation.description,
        price: comanda.price,
        quantity: 1,
        total: comanda.price,
        editable: false
    });

    form.total = form.comandas.reduce((acc, item) => acc + parseFloat(item.total), 0).toFixed(2);
    form.payments[0].amount = form.total;
}

const calculateTotals = (index) => {
    let Obj = form.comandas[index];
    let c = parseFloat(Obj.quantity) ?? 0;
    let p = parseFloat(Obj.price) ?? 0;

    let st = c*p;
    if (isNaN(st)) {
        st = 0;
    }
    form.comandas[index].total = st.toFixed(2);
    form.total = form.comandas.reduce((acc, item) => acc + parseFloat(item.total), 0).toFixed(2);
    form.payments[0].amount = form.total;
}

const removeItem = (index) => {
    let t = parseFloat(form.comandas[index].total);
    form.total = parseFloat(form.total) - t;
    form.comandas.splice(index,1);
    form.payments[0].amount = form.total;
}

const boxStyle = {
    marginTop: '10px',
    width: '100%',
    padding: '4px',
    borderRadius: '6px',
    border: '1px solid #E5E7EB',
};

const addPayments = () => {
    form.payments.push({
        type:1,
        reference: null,
        amount:0
    });
}

const removePayment = (index) => {
    if(form.payments.length > 1){
        form.payments.splice(index,1);
    }
};

const saveSale = () => {
    form.processing = true;
    return axios.post(route('res_sales_store', form)).then((res) => {
        if (!res.data.success) {
            message.error(res.data.message);
        }else{
            message.success(res.data.message);
        }
        form.processing = false;
        form.reset();
    });
}

const cancelSale = () => {
    message.info('Confirmación pendiente');
}
</script>
<template>
    <AppLayout title="Institución">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Restaurante</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Vender</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <div class="mt-5 md:mt-0 md:col-span-2">
                <ConfigProvider :locale="esES">
                    <div class="px-4 py-5 bg-white sm:rounded-tl-md sm:rounded-tr-md sm:p-6 shadow dark:bg-gray-800 ">
                        <div class="grid grid-cols-6">
                            <div class="col-span-6 sm:col-span-2">
                                <div class="card-container p-2 border-r">
                                    <Tabs v-model:activeKey="activeKey" type="card">
                                        
                                        <TabPane v-for="(item, index) in comandas" :key="index.toString()" :tab="item.description">
                                            <Card v-if="item.subcategories && item.subcategories.length > 0">
                                                <CardGrid v-for="(subcategory, cc) in item.subcategories"
                                                    style="width: 50%; text-align: center; cursor: pointer"
                                                    @click="getComandas(subcategory.comandas)"
                                                >
                                                {{ subcategory.description }}
                                                </CardGrid>
                                            </Card>
                                            <Card v-if="comandasData && comandasData.length > 0">
                                                <CardGrid v-for="(comanda, ii) in comandasData"
                                                    style="width: 25%; text-align: center;padding: 4px;border-radius: 0px;cursor: pointer"
                                                    @click="addComanda(comanda)"
                                                >
                                                    <Popover :title="comanda.name" placement="right">
                                                        <template #content>
                                                            <small>{{ comanda.description }}</small>
                                                            <p>{{ comanda.presentation.description }}</p>
                                                            <p><strong>Precio S/. {{ comanda.price }}</strong></p>
                                                        </template>
                                                        <img class="w-20 h-20" :src="xhttp + 'storage/' + comanda.image" />
                                                    </Popover>
                                                </CardGrid>
                                            </Card>
                                        </TabPane>
                                    </Tabs>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <div class="p-4">
                                    <InputLabel for="client_id" value="Cliente *" class="mb-1" />
                                    <Select
                                        id="client_id"
                                        show-search
                                        placeholder="Seleccione un cliente"
                                        v-model:value="form.client_id"
                                        style="width: 100%"
                                        :options="clients.map((obj) => ({value: obj.id, label: obj.full_name}))"
                                        :filter-option="filterOption"
                                    >
                                        <template #suffixIcon>
                                            <font-awesome-icon :icon="faFaceSmile" />
                                        </template>
                                    </Select>
                                    <InputError :message="form.errors.client_id" class="mt-2" />
                                </div>
                                <div class="p-4">
                                    
                                    <Table 
                                        :columns="columns" 
                                        :data-source="form.comandas"
                                        :pagination="false"
                                        bordered
                                    >
                                        <template #bodyCell="{ column, record, index }">
                                            <template v-if="column.key === 'name'">
                                                <Popover :title="record.name" placement="right">
                                                    <template #content>
                                                        <p>
                                                            <img class="w-40 h-40" :src="xhttp + 'storage/' + record.image" />
                                                        </p>
                                                        <small>{{ record.description }}</small>
                                                        <p>{{ record.presentation }}</p>
                                                    </template>
                                                    <p style="cursor: pointer;">{{ record.name }}</p>
                                                </Popover>
                                            </template>
                                            <template  v-if="column.key === 'quantity'">
                                                <template v-if="record.editable">
                                                    <InputNumber v-model:value="record.quantity"
                                                        @change="calculateTotals(index)" 
                                                        :id="'small-input'+column.key" 
                                                    />
                                                </template>
                                                <template v-else>
                                                    {{ record.quantity }}
                                                </template>
                                            </template>
                                            <template v-else-if="column.dataIndex === 'operation'">
                                                <div class="editable-row-operations">
                                                    <span v-if="record.editable">
                                                        <Tooltip placement="topLeft" title="Cancelar Edición">
                                                            <Button @click="record.editable = false" type="dashed" shape="circle">
                                                                <font-awesome-icon :icon="faXmark" />
                                                            </Button>
                                                        </Tooltip>
                                                    </span>
                                                    <span v-else>
                                                        <Tooltip placement="topLeft" title="Editar Cantidad">
                                                            <Button @click="record.editable = true" type="primary" shape="circle">
                                                                <font-awesome-icon :icon="faPen" />
                                                            </Button>
                                                        </Tooltip>
                                                        <Tooltip placement="bottomLeft" title="Quitar Comanda">
                                                            <Button @click="removeItem(index)" danger shape="circle" class="ml-1">
                                                                <font-awesome-icon :icon="faXmark" />
                                                            </Button>
                                                        </Tooltip>
                                                    </span>
                                                </div>
                                            </template>
                                        </template>
                                        <template #footer>
                                            <Flex :justify="'flex-end'" :align="'center'">
                                                <strong>TOTAL: {{ form.total }}</strong>
                                            </Flex>
                                        </template>
                                    </Table>
                                    <Flex :justify="'flex-start'" :align="'center'" class="mt-6">
                                        <Button @click="addPayments()" type="link">Agregar Pagos</Button>
                                    </Flex>
                                    <template v-for="(met, ky) in form.payments">
                                        <Flex :style="{ ...boxStyle }" :justify="'space-between'" :align="'center'">
                                            <DangerButton @click="removePayment(ky)" class="mr-1">
                                                <font-awesome-icon :icon="faTimes" />
                                            </DangerButton>
                                            <Select
                                                class="mr-1"
                                                v-model:value="met.type"
                                                style="width: 220px"
                                                :options="paymentMethods.map((obj) => ({value: obj.id, label: obj.description}))"
                                            />
                                            <Input v-model:value="met.reference" style="width: 220px;margin-right: 4px;" placeholder="Referencia" />
                                            <Input v-model:value="met.amount" style="width: 120px; text-align: right;" />
                                        </Flex>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md dark:bg-gray-700">
                        <Keypad>
                            <template #botones>
                                <Popconfirm title="Por favor, verifique los datos antes de confirmar." 
                                    @confirm="saveSale" 
                                    @cancel="cancelSale">
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="button">
                                        <font-awesome-icon class="mr-1" :icon="faDollarSign" />
                                        Cobrar
                                    </PrimaryButton>
                                </Popconfirm>
                                <Link :href="route('res_menu_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                            </template>
                        </Keypad>
                    </div>
                </ConfigProvider>
            </div>
        </div>

    </AppLayout>
</template>

<style scoped>
    .card-container {
        margin-bottom: 16px;
    }
    .card-container p {
        margin: 0;
        margin-bottom: 16px;
    }
    .card-container > .ant-tabs-card .ant-tabs-content {
        height: 120px;
        margin-top: -16px;
        
    }
    .card-container > .ant-tabs-card .ant-tabs-content > .ant-tabs-tabpane {
        /* padding: 16px; */
        background: #fff;
    }
    .card-container > .ant-tabs-card > .ant-tabs-nav::before {
        display: none;
    }
    .card-container > .ant-tabs-card .ant-tabs-tab,
    [data-theme='compact'] .card-container > .ant-tabs-card .ant-tabs-tab {
        background: transparent;
        border-color: transparent;
    }
    .card-container > .ant-tabs-card .ant-tabs-tab-active,
    [data-theme='compact'] .card-container > .ant-tabs-card .ant-tabs-tab-active {
        background: #fff;
        border-color: #fff;
    }
    #components-tabs-demo-card-top .code-box-demo {
        padding: 24px;
        overflow: hidden;
        background: #f5f5f5;
    }
    [data-theme='compact'] .card-container > .ant-tabs-card .ant-tabs-content {
        height: 120px;
        margin-top: -8px;
    }
    [data-theme='dark'] .card-container > .ant-tabs-card .ant-tabs-tab {
        background: transparent;
        border-color: transparent;
    }
    [data-theme='dark'] #components-tabs-demo-card-top .code-box-demo {
        background: #000;
    }
    [data-theme='dark'] .card-container > .ant-tabs-card .ant-tabs-content > .ant-tabs-tabpane {
        background: #141414;
    }
    [data-theme='dark'] .card-container > .ant-tabs-card .ant-tabs-tab-active {
        background: #141414;
        border-color: #141414;
    }

</style>