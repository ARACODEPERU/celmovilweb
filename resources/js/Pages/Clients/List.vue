<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm, Link } from '@inertiajs/vue3';
    import { faTrashAlt, faPencilAlt } from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue'
    import Keypad from '@/Components/Keypad.vue';

    const props = defineProps({
        clients: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
    })
    const form = useForm({
        search: props.filters.search,
    });

    const formDelete = useForm({});

    function destroy(id) {
        if (confirm("¿Estás seguro de que quieres eliminar?")) {
            formDelete.delete(route('clients.destroy', id));
        }
    }
</script>

<template>
    <AppLayout title="Create Team">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Académico</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Instituciones</span>
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
                                <form id="form-search-items" @submit.prevent="form.get(route('clients.index'))">
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
                                        <Link v-can="'clientes_nuevo'" :href="route('clients.create')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                            Nuevo
                                        </Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <table class="border mb-4" style="width: 100%;">
                            <thead class="border-b">
                                <tr>
                                    <th scope="col" class="w-2.5 text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                    #
                                    </th>
                                    <th scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                        Acción
                                    </th>
                                    <th scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                        Nombres y Apellidos
                                    </th>
                                    <th scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                        DNI/RUC
                                    </th>
                                    <th scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                        Teléfono
                                    </th>
                                    <th scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                        Email
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(client, index) in clients.data" :key="client.id" class="border-b">
                                    <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                        <div class="flex space-x-2 justify-center">
                                            <div>
                                                <Link :href="route('clients.edit',client.id)" class="mr-1 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">
                                                    <font-awesome-icon :icon="faPencilAlt" />
                                                </Link>
                                                <button type="button" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                                @click="destroy(client.id)"
                                                >
                                                <font-awesome-icon :icon="faTrashAlt" />
                                            </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                        {{ client.full_name }}
                                    </td>
                                    <td class="text-center text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                        {{ client.number.toString().length == 8 ? "DNI: "+client.number : client.number}}
                                    </td>
                                    <td class="text-center text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                        {{ client.telephone }}
                                    </td>
                                    <td class="text-center text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                        {{ client.email }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="clients" />
                </div>

            </div>
        </div>
    </AppLayout>
</template>
