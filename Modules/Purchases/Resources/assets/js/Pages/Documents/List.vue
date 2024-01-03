<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm, router, Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { faXmark, faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";
    import Keypad from '@/Components/Keypad.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { Badge } from 'flowbite-vue'
    import { ConfigProvider, Popconfirm, Button, message } from 'ant-design-vue';

    const props = defineProps({
        documents: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
    })
    const form = useForm({
        search: props.filters.search
    });

    const btnAll = ref(false);

    if(props.filters.search){
        btnAll.value = true
    }

    const clearSearch = () => {
        form.search = null
        form.get(route('purc_documents_list'))
        btnAll.value = false
    }

    const CancelPurchase = (id) => {
        return axios.get(route('purc_documents_anular', id)).then((res) => {
            if (!res.data.success) {
                message.error(res.data.message);
            }else{
                message.success(res.data.message);
            }
            router.visit(route('purc_documents_list'), {
                method: 'get'
            });
        });
    }
    
</script>

<template>
    <AppLayout title="Compras">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Compras</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Lista de Documentos</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark ">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-4">
                            <div class="col-span-4 sm:col-span-2">
                                <form class="flex items-center" @submit.prevent="form.get(route('purc_documents_list'))">   
                                    <div class="flex">
                                        <label for="table-search" class="sr-only">Search</label>
                                        <div class="relative w-full">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <input v-model="form.search" type="date" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar">
                                        </div>
                                        <button v-if="btnAll" @click="clearSearch" type="button" class="ml-1 py-2 px-2.5 ms-2 text-sm font-medium text-white bg-gray-700 rounded-lg border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            <font-awesome-icon class="w-4 h-4" :icon="faXmark" />
                                        </button>
                                        <button type="submit" class="ml-1 py-2 px-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <font-awesome-icon class="w-4 h-4" :icon="faMagnifyingGlass" />
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <Keypad>
                                    <template #botones>
                                        <Link :href="route('purc_documents_create')" class="inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Nuevo</Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <ConfigProvider>
                            <table class="w-full table-auto">
                                <thead class="border-b border-stroke">
                                    <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                        <th style="width: 75px;" class="py-1 px-4 text-center font-medium text-black dark:text-white">
                                            Acciones
                                        </th>
                                        <th class="py-2 px-2 font-medium text-black dark:text-white">
                                            Tipo
                                        </th>
                                        <th class="py-2 px-2 font-medium text-black dark:text-white">
                                            Nmr. Documento
                                        </th>
                                        <th class="py-2 px-2 font-medium text-black dark:text-white">
                                            Fecha
                                        </th>
                                        <th class="py-2 px-2 font-medium text-black dark:text-white">
                                            Proveedor
                                        </th>
                                        <th class="py-2 px-2 font-medium text-black dark:text-white">
                                            Total
                                        </th>
                                        <th class="py-2 px-2 font-medium text-black dark:text-white">
                                            Estado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(document, index) in documents.data" :key="document.id">
                                        <tr >
                                            <td class="py-2 px-4 dark:border-strokedark">
                                                <Popconfirm
                                                    placement="right"
                                                    title="Are you sure delete this task?"
                                                    ok-text="Si"
                                                    cancel-text="No"
                                                    @confirm="CancelPurchase(document.id)"
                                                    
                                                >
                                                    <Button type="dashed">Anular</Button>
                                                </Popconfirm>
                                            </td>
                                            <td class="py-2 px-4 dark:border-strokedark">
                                                {{ document.type.description }}
                                            </td>
                                            <td class="py-2 px-4 dark:border-strokedark">
                                                {{ document.serie }}-{{ document.number }}
                                            </td>
                                            <td class="py-2 px-2 dark:border-strokedark">
                                                {{ document.date_of_issue }}
                                            </td>
                                            <td class="py-2 px-2 dark:border-strokedark">
                                                {{ document.provider.full_name }}
                                            </td>
                                            <td class="text-right py-2 px-2 dark:border-strokedark">
                                                {{ document.total }}
                                            </td>
                                            <td  class="text-center py-1 px-4 dark:border-strokedark">
                                                <Badge v-if="document.status == 'R'" type="default">Registrado</Badge>
                                                <Badge v-else-if="document.status == 'A'" type="red">Anulado</Badge>
                                                <Badge v-else-if="document.status == 'E'" type="purple">Enviado</Badge>
                                                <Badge v-else-if="document.status == 'Ap'" type="yellow">Aprobado</Badge>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </ConfigProvider>
                        <Pagination :data="documents" />
                    </div>
                </div>
            </div>
        </div>
        
    </AppLayout>
</template>
<style scoped>
.invoice-select{
    margin: 0px !important;
    padding: 1px !important;
    height: 26px !important;
    width: 100% !important;
    font-size: 12px;
}
.invoice-imput{
    margin: 0px !important;
    padding: 1px !important;
    height: 26px !important;
    width: 100% !important;
    font-size: 12px;
}
.invoice-textarea{
    margin: 0px !important;
    padding: 1px !important;
    width: 100% !important;
    font-size: 12px;
}
</style>