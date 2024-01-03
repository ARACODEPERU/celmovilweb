<script setup>
import { ref } from 'vue';
import { 
    faPoll, 
    faGear, 
    faBolt, 
    faUserGear,
    faEarthAmericas,
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

</script>
<!-- @click.outside="sidebarToggle = false" -->
<template>
    <aside :class="sidebarToggle  ? 'translate-x-0' : '-translate-x-full'"
        class="absolute left-0 top-0 z-999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
        >
                <!-- SIDEBAR HEADER -->
        <div class="flex items-center justify-between gap-2 px-6 py-4 lg:py-3.5 dark:bg-gray-800">
            <Link  :href="route('dashboard')">
                <img :src="$page.props.company.logo_dark"  alt="Logo" />
            </Link >

            <button class="block lg:hidden" @click.stop="closeSidebarToggle">
            <svg
                class="fill-current"
                width="20"
                height="18"
                viewBox="0 0 20 18"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                fill=""
                />
            </svg>
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

                                    <svg v-if="item.items && item.items.length > 0"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                        fill=""
                                        />
                                    </svg>
                                </a>
                                <Link v-else
                                    :href="item.route" 
                                    class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4">
                                    <font-awesome-icon :icon="item.icom" />
                                    {{ item.text }}

                                    <svg v-if="item.items && item.items.length > 0"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                        fill=""
                                        />
                                    </svg>
                                </Link>
                                <!-- Dropdown Menu Start -->
                                <div v-show="item.status" v-if="item.items && item.items.length > 0" class="overflow-hidden transition-opacity duration-500">
                                    <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                        <template v-for="(subItem, subIndex) in item.items" :key="subIndex">
                                            <li v-can="subItem.permissions">
                                                <Link :href="subItem.route" class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white">
                                                    {{ subItem.text }}
                                                </Link >
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