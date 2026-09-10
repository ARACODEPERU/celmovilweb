<script  setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm, Link, router  } from '@inertiajs/vue3';
    import Keypad from '@/Components/Keypad.vue';
    import Pagination from '@/Components/Pagination.vue';
    import Swal2 from "sweetalert2";
    import ModalMedium from '@/Components/ModalMedium.vue';
    import { faPencilAlt, faImage, faTrashAlt } from "@fortawesome/free-solid-svg-icons";
    import { ref } from 'vue';
    import { 
      ConfigProvider, Image,
      Tooltip, Upload, Modal,
      message,
      Switch
    } from 'ant-design-vue';
    import esES from 'ant-design-vue/es/locale/es_ES';
    import { PlusOutlined } from '@ant-design/icons-vue';

    const props = defineProps({
        items: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        type: {
            type: String,
            default: null,
        },
        csrfToken:{
            type: String,
            default: null
        }
    });

    const xassetUrl = assetUrl;

    const form = useForm({
        search: props.filters.search,
    });

    const destroyItem = (id) => {
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
                return axios.delete(route('onlineshop_items_destroy', id)).then((res) => {
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
                router.visit(route('onlineshop_items'), { replace: true, method: 'get' });
            }
        });
    }

    const itemImages =  ref({
        item_id: null,
        item_name: null,
        images: []
    });
    const displayModalImages = ref(false);
    
    const openModalImagesItem = (item) => {
        itemImages.value.item_id = item.id
        itemImages.value.item_name = item.name

        if(item.images.length > 0){
            itemImages.value.images = item.images.map((obj) => ({
                uid: obj.id,
                name: obj.image_name,
                status: 'done',
                url: xassetUrl + 'storage/' + obj.image_path,
            }));
        } else {
            itemImages.value.images = [];
        }


        displayModalImages.value = true;
    }

    const closeModalImagesItem = () => {
        displayModalImages.value = false;
        router.visit(route('onlineshop_items'), { preserveState: true, method: 'get' });
    }

    const previewVisible = ref(false);
    const previewImage = ref('');
    const previewTitle = ref('');

    function getBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    }
    const beforeUpload = (file) => {
        const isImage = file.type.startsWith('image/');
        if (!isImage) {
            Swal2.fire('Error',`${file.name} no es un archivo de imagen (PNG, JPG, JPEG)`,'error');
        }
        return isImage || Upload.LIST_IGNORE;
    };

    const handlePreview = async (file) => {
        if (!file.url && !file.preview) {
            file.preview = (await getBase64(file.originFileObj));
        }
        previewImage.value = file.url || file.preview;
        previewVisible.value = true;
        previewTitle.value = file.name || file.url.substring(file.url.lastIndexOf('/') + 1);
    };

    const handleCancel = () => {
        previewVisible.value = false;
        previewTitle.value = '';
    };
    
    const headers = { 
        authorization: 'authorization-text',
        'X-CSRF-TOKEN': props.csrfToken
    };

    const handleChangeImages = (event) => {
        if(event.file.status == 'removed'){
            axios.delete(route('onlineshop_items_images_destroy', event.file.uid)).then(() => {
                router.visit(route('onlineshop_items'), { preserveState: true, method: 'get' });
            });
        }
    }

    const updateStockItem = (id, state) => {
        let st = state ? 1 : 0;
        axios.get(route('onlineshop_items_update_stock', [id, st])).then(() => {
            message.info('Actualizado correctamente');
        }).then(()=>{
            router.visit(route('onlineshop_items'), { preserveState: true, method: 'get' });
        });
    }

    const desdes = 1;

    const initials = (name = '') => {
        if (!name) return '?';
        const parts = name.trim().split(/\s+/);
        if (parts.length === 1) return parts[0].slice(0, 2).toUpperCase();
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    };
</script>

<template>
    <AppLayout title="Productos en linea">
        <ConfigProvider :locale="esES">
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ventas en línea</span>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Productos & servicios</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <!-- ====== Table Section Start -->
                <div class="flex flex-col gap-10">
                    <!-- ====== Table One Start -->
                    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark ">
                        <div class="w-full px-4 py-3 border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800 flex flex-wrap items-center justify-between gap-3">
                            <form id="form-search-items" @submit.prevent="form.get(route('onlineshop_items'))" class="w-full sm:max-w-xs flex-1">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input v-model="form.search" type="text" id="table-search-users" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por Descripción">
                                </div>
                            </form>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <Link v-can="'onli_items_nuevo'" :href="route('onlineshop_items_create')" class="inline-flex items-center justify-center px-4 py-2 bg-blue-900 text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                    Nuevo
                                </Link>
                                <Link v-if="!$page.props.auth.user" :href="route('login')" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                    Panel de inicio
                                </Link>
                            </div>
                        </div>
                        <!-- Desktop Table -->
                        <div class="hidden md:block max-w-full overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="py-2 px-4 text-center font-medium text-black dark:text-white">
                                            Acciones
                                        </th>
                                        <th class="py-2 px-4 text-center font-medium text-black dark:text-white">
                                            Imagen
                                        </th>
                                        <th v-if="type == 1" class="py-2 px-4 font-medium text-black dark:text-white">
                                            Categoría
                                        </th>
                                        <th class="py-2 px-4 font-medium text-black dark:text-white">
                                            Nombre
                                        </th>
                                        <th v-if="type == 1" class="py-2 px-4 font-medium text-black dark:text-white">
                                            Descripción
                                        </th>
                                        <th v-if="type == 1" class="py-2 px-4 font-medium text-black dark:text-white">
                                            Tipo
                                        </th>
                                        <th v-if="type == 1" class="py-2 px-4 font-medium text-black dark:text-white">
                                            Precio
                                        </th>
                                        <th class="py-2 px-4 font-medium text-black dark:text-white">
                                            Existencia
                                        </th>
                                        <th class="py-2 px-4 font-medium text-black dark:text-white">
                                            Estado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(item, index) in items.data" :key="item.id">
                                        <tr class="border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            <td class="text-center py-2 dark:border-strokedark">
                                                <Link v-can="'onli_items_editar'" :href="route('onlineshop_items_edit',item.id)" class="mr-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <font-awesome-icon :icon="faPencilAlt" />
                                                </Link>
                                                <Tooltip>
                                                    <template #title>Galería de imágenes</template>
                                                    <button @click="openModalImagesItem(item)" type="button" class="mr-1 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                                        <font-awesome-icon :icon="faImage" />
                                                    </button>
                                                </Tooltip>
                                                <button v-can="'onli_items_eliminar'" @click="destroyItem(item.id)" type="button" class="mr-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                    <font-awesome-icon :icon="faTrashAlt" />
                                                </button>
                                            </td>
                                            <td class="p-4">
                                                <Image :src="item.image" :alt="item.name" loading="lazy" class="rounded-lg object-cover h-12 w-12 bg-gray-200 dark:bg-gray-700" 
    :data-src="item.image" 
    :srcset="item.image + '?w=48 48w, ' + item.image + '?w=96 96w'"
    sizes="(max-width: 768px) 48px, 96px" />
                                            </td>
                                            <td v-if="type == 1" class="py-2 px-2 dark:border-strokedark">
                                                {{ item.category_description }}
                                            </td>
                                            <td class="py-2 px-2 dark:border-strokedark font-medium text-black dark:text-white">
                                                {{ item.name }}
                                            </td>
                                            <td v-if="type == 1" class="py-2 px-2 dark:border-strokedark text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                                {{ item.description }}
                                            </td>
                                            <td v-if="type == 1" class="py-2 px-2 dark:border-strokedark">
                                            </td>
                                            <td v-if="type == 1" class="py-2 px-2 text-right dark:border-strokedark font-medium">
                                                {{ item.price }}
                                            </td>
                                            <td class="text-center py-2 px-2 dark:border-strokedark">
                                                <Switch :checkedValue="1" @change="updateStockItem(item.id,item.existence)" v-model:checked="item.existence" checked-children="Disponible" un-checked-children="Agotado" class="bg-gray-700" />
                                            </td>
                                            <td class="text-center py-2 px-2 dark:border-strokedark">
                                                <span v-if="item.status" class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 14.707a1 1 0 01-1.414 1.414L8 12.414 4.707 9.121a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                                    Activo
                                                </span>
                                                <span v-else class="inline-flex items-center gap-1 bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.28a1 1 0 00-1.41 1.41L8.59 10l-1.28 1.28a1 1 0 101.41 1.41L10 11.41l1.28 1.28a1 1 0 101.41-1.41L11.41 10l1.28-1.28a1 1 0 00-1.41-1.41L10 8.59 8.72 7.28a1 1 0 00-1.41 1.41z" clip-rule="evenodd"/></svg>
                                                    Inactivo
                                                </span>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            <template v-for="(item, index) in items.data" :key="item.id">
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div class="p-4">
                                        <div class="flex items-start gap-4">
                                            <div class="relative flex-shrink-0 w-20 h-20">
                                                <template v-if="item.image">
                                                    <img
                                                        :src="item.image"
                                                        :alt="item.name"
                                                        loading="lazy"
                                                        class="w-full h-full rounded-lg object-cover bg-gray-200 dark:bg-gray-700 shadow-sm"
                                                        :srcset="item.image + '?w=80 80w, ' + item.image + '?w=160 160w'"
                                                        sizes="(max-width: 768px) 80px, 160px"
                                                    />
                                                </template>
                                                <template v-else>
                                                    <div class="w-full h-full rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                                        <div class="text-center">
                                                            <span class="text-lg font-semibold text-gray-400 dark:text-gray-500">{{ initials(item.name) }}</span>
                                                            <svg class="w-8 h-8 mx-auto mt-1 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        </div>
                                                    </div>
                                                </template>
                                                <span v-if="item.status" class="absolute -top-2 -right-2 flex items-center justify-center w-5 h-5 bg-green-500 text-white text-xs rounded-full shadow">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 14.707a1 1 0 01-1.414 1.414L8 12.414 4.707 9.121a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                                </span>
                                                <span v-else class="absolute -top-2 -right-2 flex items-center justify-center w-5 h-5 bg-red-500 text-white text-xs rounded-full shadow">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.28a1 1 0 00-1.41 1.41L8.59 10l-1.28 1.28a1 1 0 101.41 1.41L10 11.41l1.28 1.28a1 1 0 101.41-1.41L11.41 10l1.28-1.28a1 1 0 00-1.41-1.41L10 8.59 8.72 7.28a1 1 0 00-1.41 1.41z" clip-rule="evenodd"/></svg>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-2">
                                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">{{ item.name }}</h3>
                                                </div>
                                                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-600 dark:text-gray-400">
                                                    <span v-if="type == 1" class="inline-flex items-center gap-1">
                                                        <svg class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                                        {{ item.category_description }}
                                                    </span>
                                                    <span v-if="type == 1 && item.price" class="font-medium text-gray-900 dark:text-white ml-auto">{{ item.price }}</span>
                                                </div>
                                                <p v-if="type == 1 && item.description" class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-2">{{ item.description }}</p>
                                                <div class="mt-3 flex items-center justify-between">
                                                    <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                        <span class="capitalize font-medium">{{ item.existence ? 'Disponible' : 'Agotado' }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <Link v-can="'onli_items_editar'" :href="route('onlineshop_items_edit',item.id)" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-blue-700 hover:bg-blue-800 rounded-lg shadow-sm transition">
                                                            <font-awesome-icon :icon="faPencilAlt" class="w-3.5 h-3.5" />
                                                        </Link>
                                                        <Tooltip>
                                                            <template #title>Galería</template>
                                                            <button @click="openModalImagesItem(item)" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-gray-700 hover:bg-gray-800 rounded-lg shadow-sm transition">
                                                                <font-awesome-icon :icon="faImage" class="w-3.5 h-3.5" />
                                                            </button>
                                                        </Tooltip>
                                                        <button v-can="'onli_items_eliminar'" @click="destroyItem(item.id)" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-700 hover:bg-red-800 rounded-lg shadow-sm transition">
                                                            <font-awesome-icon :icon="faTrashAlt" class="w-3.5 h-3.5" />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <Pagination :data="items" />
                    </div>
                </div>
            </div>
            <ModalMedium
                :onClose="closeModalImagesItem"
                :show="displayModalImages"
                :icon="'/img/imagen.png'"
            >
                <template #title>
                    Galería de imágenes
                </template>
                <template #message>{{ itemImages.item_name }}</template>
                <template #content>

                    <div class="clearfix">
                        <Upload
                            v-model:file-list="itemImages.images"
                            :action="route('onlineshop_items_images_upload')"
                            list-type="picture-card"
                            :before-upload="beforeUpload"
                            @preview="handlePreview"
                            :headers="headers"
                            :data="{item_id: itemImages.item_id}"
                            @change="handleChangeImages"
                        >
                            <div v-if="itemImages.images.length < 11">
                                <plus-outlined />
                                <div style="margin-top: 8px">Upload</div>
                            </div>
                        </Upload>
                        <Modal :zIndex="9999999" :open="previewVisible" :title="previewTitle" :footer="null" @cancel="handleCancel">
                            <img alt="example" style="width: 100%" :src="previewImage" />
                        </Modal>
                    </div>
                </template>
            </ModalMedium>

        </ConfigProvider>
    </AppLayout>
</template>
