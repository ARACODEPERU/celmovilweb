<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import Keypad from '@/Components/Keypad.vue';
    import ModalLargeXX from '@/Components/ModalLargeXX.vue';
    import Pagination from '@/Components/Pagination.vue';
    import StatusLoading from '@/Components/StatusLoading.vue';
    import { Space, Tooltip, Transfer, ConfigProvider } from 'ant-design-vue';
    import esES from 'ant-design-vue/es/locale/es_ES';
    import Swal2 from "sweetalert2";
    import { Link, router } from '@inertiajs/vue3';
    import { faPencilAlt, faHotdog, faTrashAlt, faPrint } from "@fortawesome/free-solid-svg-icons";
    import { ref, onMounted } from 'vue';


    const props = defineProps({
        menus: {
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

    const destroyMenu = (id) => {
        Swal2.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, Eliminar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return axios.delete(route('res_menus_destroy', id)).then((res) => {
                    if (!res.data.success) {
                        Swal2.showValidationMessage(res.data.message)
                    }
                    return res
                });
            },
            allowOutsideClick: () => !Swal2.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal2.fire({
                    title: 'Enhorabuena',
                    text: 'Se Eliminó correctamente',
                    icon: 'success',
                });
                router.visit(route('res_menu_list'), { replace: true, method: 'get' });
            }
        });
    }

    const xhttp =  assetUrl;
    const displayModalAddComanda = ref(false);
    const comandasData = ref({
        menu_id: null,
        menu_name: null,
        loading: false
    });

    const showModalAddComanda = async  (menu) => {
        comandasData.value.menu_id = menu.id;
        comandasData.value.loading = true;
        comandasData.value.menu_name = menu.name;
        axios.get(route('res_menus_comandas', menu.id)).then((res) => {
            return getComandas(res.data.comandasFree).then(res => {
                mockData.value = res.mockData;
                targetKeys.value = res.targetKeys;
                return true;
            });
            
        }).then(() => {
            comandasData.value.loading = false;
        });
        displayModalAddComanda.value = true;
    }

    const closeModalAddComanda = () => {
        displayModalAddComanda.value = false;
    }
    const mockData = ref([]);
    const targetKeys = ref([]);

    const getComandas = async (comandas) => {
        const keys = [];
        const mData = [];
        for (let i = 0; i < comandas.length; i++) {
            const data = {
                key: String(comandas[i].id),
                title: comandas[i].name,
                description: comandas[i].description,
                chosen: comandas[i].chosen,
            };
            if (data.chosen) {
                keys.push(data.key);
            }
            mData.push(data);
        }
        return { mockData: mData, targetKeys: keys };
        
    };

    const filterOption = (inputValue, option) => {
        const inputValueLower = inputValue.toLowerCase();
        const optionTitleLower = option.title.toLowerCase();

        return optionTitleLower.includes(inputValueLower);
    };
    const handleChange = (keys) => {
        let id = comandasData.value.menu_id;
        axios.put(route('res_menus_comandas_store', id),{
            comandas: keys
        });
    };

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Menu Del Día</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form id="form-search-items" @submit.prevent="form.get(route('res_comandas_list'))">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <input v-model="form.search" type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por Descripción">
                                    </div>
                                </form>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <Keypad>
                                    <template #botones>
                                        <Link v-can="'res_menu_nuevo'" :href="route('res_menu_create')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                            Nuevo
                                        </Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th  class="py-2 px-4 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Nombre
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Descripción
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(menu, index) in menus.data" :key="menu.id">
                                    <tr class="border-b border-stroke">
                                        <td class="text-center py-2 dark:border-strokedark">
                                            <Space>
                                                <div v-can="'res_menu_editar'">
                                                    <Tooltip  placement="topLeft" title="Editar">
                                                        <Link :href="route('res_menus_edit',menu.id)" class="mr-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <font-awesome-icon :icon="faPencilAlt" />
                                                        </Link>
                                                    </Tooltip>
                                                </div>
                                                <div v-can="'res_menu_verimprimir'">
                                                    <Tooltip placement="top" title="Ver e Imprimir">
                                                        <Link :href="route('res_menus_show',menu.id)" class="mr-1 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                                            <font-awesome-icon :icon="faPrint" />
                                                        </Link>
                                                    </Tooltip>
                                                </div>
                                                <div v-can="'res_menu_agregar_comandas'">
                                                    <Tooltip placement="top" title="Agregar Comandas">
                                                        <button @click="showModalAddComanda(menu)" type="button" class="mr-1 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                            <font-awesome-icon :icon="faHotdog" />
                                                        </button>
                                                    </Tooltip>
                                                </div>
                                                <div v-can="'res_menu_eliminar'">
                                                    <Tooltip placement="topRight" title="Eliminar" arrow-point-at-center>
                                                        <button @click="destroyMenu(menu.id)" type="button" class="mr-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                            <font-awesome-icon :icon="faTrashAlt" />
                                                        </button>
                                                    </Tooltip>
                                                </div>
                                            </Space>
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ menu.name }}
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ menu.description }}
                                        </td>
                                        <td class="text-center py-2 px-2 dark:border-strokedark">
                                            <span v-if="menu.status" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Activo</span>
                                            <span v-else class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Inactivo</span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="menus" />
                </div>
            </div>
        </div>
        <ModalLargeXX
            :onClose="closeModalAddComanda"
            :show="displayModalAddComanda"
            :icon="'/img/cubiertos.png'"
        >
            <template #title>
                Agregar Comandas
            </template>
            <template #message>
                {{ comandasData.menu_name }}
            </template>
            <template #content>
                <StatusLoading v-if="comandasData.loading" class="w-full"></StatusLoading>
                <div v-else>
                    <ConfigProvider :locale="esES">
                        <Transfer
                            :list-style="{
                                width: '100%',
                                height: '300px',
                            }"
                            v-model:target-keys="targetKeys"
                            :data-source="mockData"
                            show-search
                            :filter-option="filterOption"
                            :operations="['Agregar', 'Quitar']"
                            :render="item => item.title"
                            @change="handleChange"
                        />
                    </ConfigProvider>
                </div>
            </template>
        </ModalLargeXX>
    </AppLayout>
</template>
