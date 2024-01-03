<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import Keypad from '@/Components/Keypad.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    resmenu: {
        type: Object,
        default: () => ({}),
    },

});
const xhttp =  assetUrl;


const printMenu = () => {

    var ventana = window.open('', '_blank');
    var estilos = document.querySelectorAll('link[rel="stylesheet"]');
    estilos.forEach(function(estilo) {
        ventana.document.head.appendChild(estilo.cloneNode(true));
    });

    // Agrega el contenido del div a la nueva ventana
    var contenidoDiv = document.getElementById('divPrintMenu').outerHTML;
    ventana.document.body.innerHTML = contenidoDiv;

    // Imprime la nueva ventana
    ventana.print();
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
                    <li>
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <!-- <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Productos</a> -->
                        <Link :href="route('res_menu_list')"><span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Menu Del Día</span></Link>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nuevo</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div id="divPrintMenu" class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div style="border-color: black;background-color: #FFF;border-radius: 4px;padding: 6px;">
                    <table style="width: 100%;">
                        <tr>
                            <th colspan="3" >
                                <h2>{{ resmenu.name }}</h2>
                                <p style="border-bottom: 2px solid #000;">{{ resmenu.description }}</p>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" >
                                
                            </th>
                        </tr>
                        <tr v-for="(item, key) in resmenu.comandas">
                            <td style="width: 70px;height: 70px;">
                                <img style="width: 70px;height: 70px;" :src="xhttp + 'storage/' + item.comanda.image" alt="">
                            </td >
                            <td style="padding: 10px;">
                                <h4>{{  item.comanda.name }}</h4>
                                <p>{{  item.comanda.description }}</p>
                            </td >
                            <td>
                                {{  item.comanda.price }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <Keypad class="mt-6">
                <template #botones>
                    <PrimaryButton @click="printMenu()">
                        Imprimir
                    </PrimaryButton>
                    <Link :href="route('res_menu_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </div>
        
    </AppLayout>
</template>

  