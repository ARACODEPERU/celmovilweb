<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { faTrashAlt, faPencilAlt, faPrint, faWarehouse } from "@fortawesome/free-solid-svg-icons";
import Pagination from '@/Components/Pagination.vue';
import Keypad from '@/Components/Keypad.vue';
import ModalSmall from '@/Components/ModalSmall.vue';
import { ref } from 'vue';
import VueMagnifier from '@websitebeaver/vue-magnifier'
import '@websitebeaver/vue-magnifier/styles.css'

const props = defineProps({
    establishments: {
        type: Object,
        default: () => ({}),
    },
    kardexes: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    local_id: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    search: props.filters.search,
    local_id: props.local_id,
});
if (form.local_id == null) {
    form.local_id = 0;
}

const dataDetails = useForm({
    kardex: {
        type: Object,
        default: () => ({}),
    },
    sizes: {
        type: Object,
        default: () => ({}),
    }
});

const displayModalDetails = ref(false);

const openModalDetailsSizes = (kardex) => {
    axios.post(route('kardex_sizes'), {
        product_id: kardex.id,
        local_id: kardex.local_id,
    }).then((res) => {
        dataDetails.kardex = kardex;
        dataDetails.sizes = res.data;
        displayModalDetails.value = true;
    });
}

const closeModalDetailsSizes = () => {
    displayModalDetails.value = false;
}

function getProductsByLocal() {

}
</script>
<template>
    <AppLayout title="Inventario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventario
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="col-span-6 p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="grid grid-cols-4 gap-4 pb-4 bg-white dark:bg-gray-900">
                        <div class="col-span-4 sm:col-span-1">
                            <InputLabel for="stablishment" value="Establecimiento" />
                            <select v-model="form.local_id" v-on:change="form.get(route('kardex_index'))"
                                id="stablishment"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">Todos los Locales</option>
                                <template v-for="(establishment, index) in props.establishments" :key="index">
                                    <option :value="establishment.id">{{ establishment.description }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <form @submit.prevent="form.get(route('kardex_index'))">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input v-model="form.search" type="text" id="table-search-users"
                                        class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Buscar producto">
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-2">
                        <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
                            <thead
                                class="text-xs text-white uppercase bg-blue-600 border-b border-blue-400 dark:text-white">
                                <tr>
                                    <th scope="col" class="text-center px-6 py-2">
                                        Cantida Por Talla
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        Tienda
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        Imagen
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        Código
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        Producto
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        Cantidad Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(kardex, index) in kardexes.data"
                                    class="bg-blue-600 border-b border-blue-400 hover:bg-blue-500">
                                    <td class="text-center px-6 py-4">
                                        <button @click="openModalDetailsSizes(kardex)" type="button"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Icon description</span>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4">{{ kardex.local_names }}</td>
                                    <td class="w-32 p-4" style="text-align: center;">
                                        <VueMagnifier 
                                            :src="'/storage/' + kardex.image" width="60px"
                                            :zoomImgSrc="'/storage/' + kardex.image" 
                                            :mgWidth="200" 
                                            :mgHeight="200" />
                                    </td>
                                    <td class="w-32 p-4">
                                        {{ kardex.interne }}
                                    </td>
                                    <td class="w-32 p-4">
                                        {{ kardex.description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ kardex.kardex_stock }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :data="kardexes" />
                </div>

            </div>
        </div>
        <ModalSmall :show="displayModalDetails" :onClose="closeModalDetailsSizes">
            <template #title>
                {{ dataDetails.kardex.local_names }}
            </template>
            <template #message>
                {{ dataDetails.kardex.interne + ' - ' + dataDetails.kardex.description }}
            </template>
            <template #content>
                <div class="flex flex-col">
                    <div class="overflow-y-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-sm font-light">
                                    <thead class="border font-medium dark:border-neutral-500">
                                        <tr>
                                            <th scope="col" class="px-6 py-2">Talla</th>
                                            <th scope="col" class="px-6 py-2">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(size, fe) in dataDetails.sizes" :key="fe"
                                            class="border dark:border-neutral-500">
                                            <td class="text-right px-6 py-2">{{ size.size }}</td>
                                            <td class="text-right px-6 py-2">
                                                {{ parseInt(size.total) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col" class="text-right px-6 py-2">TOTAL</th>
                                            <th scope="col" class="text-right px-6 py-2">{{
                                                parseInt(dataDetails.kardex.kardex_stock) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </ModalSmall>
    </AppLayout>
</template>
