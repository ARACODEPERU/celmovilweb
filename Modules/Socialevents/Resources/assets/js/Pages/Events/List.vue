<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import Keypad from '@/Components/Keypad.vue';
    import Pagination from '@/Components/Pagination.vue';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import { 
        ConfigProvider,
        Dropdown, 
        Menu, 
        MenuItem, 
        Image, 
        AvatarGroup, 
        Avatar, 
        Tooltip, 
        Badge,
        InputNumber,
        Input
    } from 'ant-design-vue';
    import Swal2 from "sweetalert2";
    import { Link, router } from '@inertiajs/vue3';
    import { faPencilAlt, faGears, faTrashAlt } from "@fortawesome/free-solid-svg-icons";
    import esES from 'ant-design-vue/es/locale/es_ES';
    import { ref } from 'vue';
    import DangerButton from '@/Components/DangerButton.vue';
    
    const props = defineProps({
        socialevents: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        types: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        search: props.filters.search,
    });

    const destroyEvent = (id) => {
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
                return axios.delete(route('even_eventos_destroy', id)).then((res) => {
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
                router.visit(route('even_eventos_list'), { replace: true, method: 'get' });
            }
        });
    }

    const xhttp =  assetUrl;

    const colors = [
        {color: 'pink'},
        {color:'red'},
        {color:'yellow'},
        {color:'orange'},
        {color:'cyan'},
        {color:'green'},
        {color:'blue'},
        {color:'purple'},
        {color:'geekblue'},
        {color:'magenta'},
        {color:'volcano'},
        {color:'gold'},
        {color:'lime'},
    ];

    const socialeventData = ref({
        event_id: null,
        title: null,
        total: null,
        loading: false,
        errors: [],
        prices: []
    });

    const displayModalPrices = ref(false);

    const openModalPrices = (evento) => {
        let typesArray = [];
        let pricesArray = evento.prices;

        props.types.forEach(typ => {
            let typeIdToFind = typ.id;
            let foundObject = {};
            let ty = {
                type_id: typ.id,
                description: typ.description,
                price: 0,
                quantity: 0,
                ticket_price: null
            }
            if(pricesArray.length > 0){
                foundObject = pricesArray.find(obj => obj.type_id === typeIdToFind);
            }
            
            if (foundObject) {
                ty.description = typ.description;
                ty.price = foundObject.price;
                ty.quantity = foundObject.quantity;
                ty.ticket_price = foundObject.id;
            }

            typesArray.push(ty);
        });

        socialeventData.value = {
            event_id: evento.id,
            title: evento.title,
            total: evento.tickets_quantity,
            prices: typesArray
        };
        displayModalPrices.value = true;
    }

    const closeModalPrices = () => {
        displayModalPrices.value = false;
        socialeventData.value = [];
    }

    const savePricesEvent = () => {
        socialeventData.value.loading = true;
        axios.post(route('even_events_preices_ticket_store'), socialeventData.value).then(response => {
            socialeventData.errors = [];
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se guardaron los cambios correctamente',
                icon: 'success',
            });
            return true;
        }).then(()=>{
            socialeventData.value.loading = false;
            router.visit(route('even_eventos_list'), { method: 'get',preserveState: true })
        }).catch(error => {
            let validationErrors = error.response.data.errors;
            if (validationErrors && validationErrors.event_id) {
                const eventIdErrors = validationErrors.event_id;

                for (let i = 0; i < eventIdErrors.length; i++) {
                    form.setError('event_id', eventIdErrors[i]);
                }
            }
            socialeventData.value.loading = false;
        });
    }
</script>

<template>
    <AppLayout title="Eventos">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Eventos sociales</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Eventos</span>
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
                                <form id="form-search-items" @submit.prevent="form.get(route('even_eventos_list'))">
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
                                        <Link v-can="'even_evento_nuevo'" :href="route('even_eventos_create')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                            Nuevo
                                        </Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <ConfigProvider :locale="esES">
                        <table class="w-full table-auto">
                            <thead class="border-b border-stroke">
                                <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                    <th  class="py-2 px-4 text-center font-medium text-black dark:text-white">
                                        Acciones
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Imagen
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Nombre
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Locales
                                    </th>
                                    <th class="py-2 px-4 font-medium text-black dark:text-white">
                                        Expositores
                                    </th>
                                    <th class="text-right py-2 px-4 font-medium text-black dark:text-white">
                                        Cantidad de Entradas
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(socialevent, index) in socialevents.data" :key="socialevent.id">
                                    <tr class="border-b border-stroke">
                                        <td class="text-center py-2 dark:border-strokedark">
                                            <Dropdown :placement="'bottomLeft'">
                                                <button class="border py-1.5 px-2 dropdown-button inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm" type="button">
                                                    <font-awesome-icon :icon="faGears" />
                                                </button>
                                                <template #overlay>
                                                    <Menu>
                                                        <MenuItem>
                                                        <Link v-can="'even_evento_editar'" :href="route('even_eventos_editar',socialevent.id)" type="Link">
                                                            Editar
                                                        </Link>
                                                        </MenuItem>
                                                        <MenuItem>
                                                            <button v-can="'even_evento_precios'" @click="openModalPrices(socialevent)" type="Link">
                                                                Precios
                                                            </button>
                                                        </MenuItem>
                                                        <MenuItem>
                                                            <button v-can="'even_evento_eliminar'" @click="destroyEvent(socialevent.id)" type="Link">
                                                                Eliminar
                                                            </button>
                                                        </MenuItem>
                                                    </Menu>
                                                </template>
                                            </Dropdown>
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            <Image v-if="socialevent.image1"
                                                :width="70"
                                                :src="xhttp + 'storage/' + socialevent.image1"
                                            />
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            {{ socialevent.title }}
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            <div v-for="(item, index) in socialevent.locales" :key="index">
                                                <Badge :text="item.local.names" :color="colors[index].color" />
                                            </div>
                                        </td>
                                        <td class="py-2 px-2 dark:border-strokedark">
                                            <AvatarGroup :max-count="2" :max-style="{ color: '#f56a00', backgroundColor: '#fde3cf' }">
                                                <template v-for="(row, ky) in socialevent.exhibitors">
                                                    <Tooltip :title="row.exhibitor.full_name" placement="top">
                                                        <template v-if="row.exhibitor.image">
                                                            <Avatar :src="row.exhibitor.image" />
                                                        </template>
                                                        <template v-else>
                                                            <Avatar :src="'https://ui-avatars.com/api/?name='+row.exhibitor.full_name+'&size=32&rounded=true'" style="background-color: #e6eef7" />
                                                        </template>
                                                    </Tooltip>
                                                </template>
                                            </AvatarGroup>
                                        </td>
                                        <td class="text-right py-2 px-2 dark:border-strokedark">
                                            {{ socialevent.tickets_quantity }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        </ConfigProvider>
                    </div>
                    <Pagination :data="socialevents" />
                </div>
            </div>
        </div>
        <ModalSmall
            :onClose="closeModalPrices"
            :show="displayModalPrices"
            :icon="'/img/etiqueta-de-precio.png'"
        >
            <template #title>
                Agregar precios
            </template>
            <template #message>
                {{ socialeventData.title }}
            </template>
            <template #content>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right">
                                TIPO
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cantidad
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(type, key) in socialeventData.prices" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="text-right p-1">* {{ type.description }}</td>
                            <td class="w-20 p-1"><InputNumber v-model:value="type.price" class="text-right" /></td>
                            <td class="w-20 p-1"><InputNumber v-model:value="type.quantity" class="text-right" /></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="px-1 py-3 text-right" colspan="2">Total de ticket</th>
                            <th class="px-4 py-3 w-20  text-right">{{ socialeventData.total }}</th>
                        </tr>
                    </tfoot>
                </table>
            </template>
            <template #buttons>
                <DangerButton @click="savePricesEvent" :class="{ 'opacity-25': socialeventData.loading }" :disabled="socialeventData.loading" class="mr-2">
                    <svg v-show="socialeventData.loading" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                    </svg>
                    Guardar Cambios
                </DangerButton>
            </template>
        </ModalSmall>
    </AppLayout>
</template>
