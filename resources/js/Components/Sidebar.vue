<script setup>
import { ref } from 'vue';
import { 
    faPoll, 
    faChevronDown, 
    faBolt, 
    faChevronUp,
    faArrowLeftLong,
    faKitMedical,
    faGlobe
 } from "@fortawesome/free-solid-svg-icons";
import { Link } from '@inertiajs/vue3';
import menuAcademic from '../../../Modules/Academic/Resources/assets/js/Menu.js';
import menuRestaurant from '../../../Modules/Restaurant/Resources/assets/js/Menu.js';
import menuSales from '../../../Modules/Sales/Resources/assets/js/Menu.js';
import menuPurchases from '../../../Modules/Purchases/Resources/assets/js/Menu.js';
import menuConfig from '../../../Modules/Security/Resources/assets/js/Menu.js';
import menuCMS from '../../../Modules/CMS/Resources/assets/js/Menu.js';
import menuSocialevents from '../../../Modules/Socialevents/Resources/assets/js/Menu.js';
import menuHelpdesk from '../../../Modules/Helpdesk/Resources/assets/js/Menu.js';

const props = defineProps({
    sidebarToggle: {
        type: Boolean,
        default: false
    }
});
const emit = defineEmits(['activateCakeButton'])
const closeSidebarToggle = async () => {
    emit('activateCakeButton', false)
};

const menu = ref([
    {
        status:false,
        text: 'Dashboard',
        icom: faPoll,
        route: route('dashboard'),
        permissions: 'dashboard',
    },
    menuConfig,
    menuPurchases,
    menuSales,
    {
        status:false,
        text: 'Ventas en línea',
        icom: faGlobe,
        route: null,
        permissions: 'onli_dashboard',
        items: [
            {
                route: route('onlineshop_items'),
                status: false,
                text: 'Productos & servicios',
                permissions: 'onli_items',
            },
            {
                route: route('onlineshop_sales'),
                status: false,
                text: 'Pedidos',
                permissions: 'onli_pedidos',
            },
        ]
    },
    {
        status:false,
        text: 'Facturación Electrónica',
        icom: faBolt,
        route: null,
        permissions: 'invo_dashboard',
        items: [
            {
                route: route('saledocuments_create'),
                status: false,
                text: 'Crear Documento',
                permissions: 'invo_documento',
            },
            {
                route: route('saledocuments_list'),
                status: false,
                text: 'Lista de Documentos',
                permissions: 'invo_documento_lista',
            },
            {
                route: route('salesummaries_list'),
                status: false,
                text: 'Resumen',
                permissions: 'invo_resumenes_lista',
            },
            {
                route: route('low_communication_list'),
                status: false,
                text: 'Comunicacion de Baja',
                permissions: 'invo_comunicacion_baja',
            }
        ]
    },
    menuHelpdesk,
    menuCMS,
    {
        status:false,
        text: 'Salud',
        icom: faKitMedical,
        route: null,
        permissions: 'heal_dashboard',
        items: [
            {
                route: route('heal_patients_list'),
                status: false,
                text: 'Pacientes',
                permissions: 'heal_pacientes_listado',
            },
            {
                route: route('dental_dashboard'),
                status: false,
                text: 'Odontología',
                permissions: 'cms_seccion',
            },
        ]
    },
    menuAcademic,
    menuRestaurant,
    menuSocialevents
]);

const toggleSubItems = (index) => {
    menu.value = menu.value.map((item, i) => ({
        ...item,
        status: i === index ? !item.status : false
    }));
};
const xasset = assetUrl;
</script>
<!-- @click.outside="sidebarToggle = false" -->
<template>
    <aside :class="sidebarToggle  ? 'translate-x-0' : '-translate-x-full'"
        class="absolute left-0 top-0 z-999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
        >
                <!-- SIDEBAR HEADER -->
        <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
            <Link  :href="route('dashboard')">
                <img :src="xasset+'storage/'+$page.props.company.logo"  alt="Logo" />
            </Link >

            <button class="block lg:hidden" @click.stop="closeSidebarToggle">
                <font-awesome-icon :icon="faArrowLeftLong" class="fill-current" />
            </button>
        </div>
        <!-- SIDEBAR HEADER -->

        <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
            <!-- Sidebar Menu -->
            <nav class="mt-5 py-4 px-4 lg:mt-9 lg:px-6" >
                <!-- Menu Group -->
                <div>
                    <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MENU</h3>
                    
                    <ul class="mb-6 flex flex-col gap-1.5">
                        <template v-for="(item, index) in menu" :key="index">
                            <li v-can="item.permissions">

                                <a v-if="item.route == null"
                                    href="#" 
                                    @click.prevent="toggleSubItems(index)"
                                    class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4">
                                    <font-awesome-icon :icon="item.icom" />
                                    {{ item.text }}

                                    <template v-if="item.items && item.items.length > 0">
                                        <font-awesome-icon v-if="item.status" :icon="faChevronUp" class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" />
                                        <font-awesome-icon v-else :icon="faChevronDown" class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" />
                                    </template>
                                </a>
                                <Link v-else
                                    :href="item.route" 
                                    class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4">
                                    <font-awesome-icon :icon="item.icom" />
                                    {{ item.text }}
                                </Link>
                                <!-- Dropdown Menu Start -->
                                <div v-show="item.status" v-if="item.items && item.items.length > 0" class="overflow-hidden transition-opacity duration-500">
                                    <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                        <template v-for="(subItem, subIndex) in item.items" :key="subIndex">
                                            <li v-can="subItem.permissions">
                                                <a v-if="subItem.route == null"
                                                    href="#" 
                                                    @click.prevent="subItem.status = !subItem.status"
                                                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white">
                                                    {{ subItem.text }}
                                                    <template v-if="subItem.items && subItem.items.length > 0">
                                                        <font-awesome-icon v-if="subItem.status" :icon="faChevronUp" class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" />
                                                        <font-awesome-icon v-else :icon="faChevronDown" class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" />
                                                    </template>
                                                </a>
                                                <Link v-else :href="subItem.route" class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white">
                                                    {{ subItem.text }}
                                                </Link >
                                                <div v-show="subItem.status" v-if="subItem.items && subItem.items.length > 0" class="overflow-hidden transition-opacity duration-500">
                                                    <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                                        <template v-for="(subSubItem, subSubIndex) in subItem.items" :key="subSubIndex">
                                                            <li v-can="subSubItem.permissions">
                                                                <Link :href="subSubItem.route" class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white">
                                                                    {{ subSubItem.text }}
                                                                </Link >
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <!-- Dropdown Menu End -->
                            </li>
                        </template>
                    </ul>
                </div>
            </nav>
            <!-- Promo Box -->
        </div>
    </aside>
</template>