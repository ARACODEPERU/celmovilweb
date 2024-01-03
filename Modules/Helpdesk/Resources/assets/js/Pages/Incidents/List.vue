<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { faTrashAlt, faPencilAlt, faUserGear} from "@fortawesome/free-solid-svg-icons";
    import { onMounted, ref } from 'vue';
    import { Link, router, useForm } from '@inertiajs/vue3';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import { ConfigProvider, Table, Input, Popconfirm, Button, Select, RadioGroup, Radio, Textarea, message, Flex } from 'ant-design-vue';
    import { Badge } from 'flowbite-vue'
    import esES from 'ant-design-vue/es/locale/es_ES';

    const props = defineProps({
        incidents: {
            type: Object,
            default: () => ({}),
        },
        categories: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
    });

    const form = useForm({
        search: props.filters.search,
    });

    const incidentsData = ref([]);

    onMounted(() => {
        incidentsData.value = props.incidents;
    });


    const columns = [
        {
            title: 'Acciones',
            dataIndex: 'operation',
            key: 'operation',
            width: '15%'
        },
        {
            title: 'Categoría',
            dataIndex: 'category',
            key: 'category',
            width: '20%',
        },
        {
            title: 'Descripción',
            dataIndex: 'description',
            key: 'description',
            width: '40%',
        },
        {
            title: 'Estado',
            dataIndex: 'status',
            key: 'status',
            width: '15%',
        }
    ]

    const editableData = ref([]);

    const editColumn = (id) => {
        // const editableDataxx = incidentsData.value.filter(item => id === item.id);
        // console.log(editableDataxx)
        const index = incidentsData.value.findIndex(item => id === item.id);

        if (index !== -1) {
            incidentsData.value[index].editable = true;
        } else {
            console.log("Elemento no encontrado");
        }
    }

    const cancelEdit = (id) => {
        const index = incidentsData.value.findIndex(item => id === item.id);

        if (index !== -1) {
            incidentsData.value[index].editable = false;
        } else {
            console.log("Elemento no encontrado");
        }
    }

    const updateColumn = (record) => {
        const key = 'updatable';
        message.loading({ content: 'Cargando...', key });
        axios.put(route('helpdesk_incidents_update',record.id),{
            description: record.description,
            status: record.status,
            category_id: record.category_id
        }).then(response => {
            const index = incidentsData.value.findIndex(item => record.id === item.id);
            if (index !== -1) {
                incidentsData.value[index].editable = false;
            } else {
                console.log("Elemento no encontrado");
            }
        }).then(()=>{
            message.success({ content: 'Se Actualizó correctamente', key, duration: 10 });
        }).catch(error => {
            message.error({ content: 'Verifique los campos requeridos', key, duration: 10 });
        });
    }

    const handleAddIncident = () => {
        let newObject = {
            id: null,
            description: null,
            status: true,
            category: null,
            category_id: null,
            editable: true
        };
        incidentsData.value.unshift(newObject);
    }

    const cancelNew = (id) => {
        const index = incidentsData.value.findIndex(item => id === item.id);

        if (index !== -1) {
            incidentsData.value.splice(index, 1)
        } else {
            console.log("Elemento no encontrado");
        }
    }

    const newColumn = (record) => {
        const key = 'updatable';
        message.loading({ content: 'Cargando...', key });
        axios.post(route('helpdesk_incidents_store'),{
            description: record.description,
            status: record.status,
            category_id: record.category_id
        }).then(() => {
            message.success({ content: 'Se registró correctamente', key, duration: 10 });
        }).then(()=>{
            router.get(route('helpdesk_incidents'));
        }).catch(error => {
            message.error({ content: 'Verifique los campos requeridos', key, duration: 10 });
        });
    }
</script>
<template>
    <AppLayout title="Banco de Preguntas">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Centro de Soporte</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Banco de Preguntas</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Breadcrumb End -->
            <ConfigProvider :locale="esES">
                <!-- ====== Table Section Start -->
                <div class="flex flex-col gap-10">
                    <!-- ====== Table One Start -->
                    <div class="rounded-sm border border-stroke bg-white  shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                            <Flex :justify="'space-between'" :align="'center'">
                                <form @submit.prevent="form.get(route('helpdesk_incidents'))">
                                    <Input 
                                        v-model:value="form.search"  
                                        placeholder="Buscar por descripción" 
                                        :allowClear="true"
                                    />
                                </form>
                                <Button @click="handleAddIncident" type="primary">Agregar</Button>
                            </Flex>
                        </div>
                        <div class="max-w-full overflow-x-auto">
                            <Table :columns="columns" :data-source="incidentsData" bordered >
                                <template #bodyCell="{ column, text, record }">
                                    <template v-if="column.dataIndex === 'operation'">
                                        <div class="editable-row-operations">
                                            <template v-if="record.id">
                                                <span v-if="record.editable">
                                                    <Button @click="updateColumn(record)" type="link">Guardar</Button>
                                                    <Popconfirm title="¿Seguro que cancelarás?" @confirm="cancelEdit(record.id)">
                                                        <Button danger type="link">Cancelar</Button>
                                                    </Popconfirm>
                                                </span>
                                                <span v-else>
                                                    <Button @click="editColumn(record.id)" type="link">Editar</Button>
                                                </span>
                                            </template>
                                            <template v-else>
                                                <span v-if="record.editable">
                                                    <Button @click="newColumn(record)" type="link">Guardar</Button>
                                                    <Popconfirm title="¿Seguro que cancelarás?" @confirm="cancelNew(record.id)">
                                                        <Button danger type="link">Cancelar</Button>
                                                    </Popconfirm>
                                                </span>
                                            </template>
                                        </div>
                                    </template>
                                    <template v-else-if="['category', 'description', 'status'].includes(column.dataIndex)">
                                        <div>
                                            <template v-if="record.editable">
                                                <template v-if="column.key === 'category'">
                                                    <Select
                                                        v-model:value="record.category_id"
                                                        style="width: 100%"
                                                        :options="categories.map((obj) => ({value:obj.id,label:obj.description}))"
                                                    ></Select>
                                                </template>
                                                <template v-else-if="column.key === 'description'">
                                                    <Textarea
                                                        v-model:value="record.description"
                                                        style="width: 100%"
                                                    />
                                                </template>
                                                <template v-else-if="column.key === 'status'">
                                                    <RadioGroup v-model:value="record.status">
                                                        <Radio :value="1">Activo</Radio>
                                                        <Radio :value="0">Inactivo</Radio>
                                                     </RadioGroup>
                                                </template>
                                                <template v-else>
                                                    {{ text }}
                                                </template>
                                            </template>
                                            <template v-else>
                                                <template v-if="column.key === 'category'">
                                                    {{ text.description }}
                                                </template>
                                                <template v-else-if="column.key === 'status'">
                                                    <Badge v-if="text" type="purple">Activo</Badge>
                                                    <Badge v-else type="green">Inactivo</Badge>
                                                </template>
                                                <template v-else>
                                                    {{ text }}
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
            </ConfigProvider>
        </div>
    </AppLayout>
</template>
