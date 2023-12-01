<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Keypad from '@/Components/Keypad.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { ref, onMounted } from 'vue';
    import Swal2 from "sweetalert2";
    import { useForm, Link, router } from '@inertiajs/vue3';
    import { faFileCircleCheck, faCirclePlay } from "@fortawesome/free-solid-svg-icons";
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        section:{
            type: Object,
            default: () => ({}),
        },
        items: {
            type: Object,
            default: () => ({}),
        },
        sItems:{
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
        items: props.items.data
    });

    const arrayItems = ref({
        section_id: props.section.id,
        description: null,
        data:[]
    });

    const setDataItems = () => {
        if (props.sItems.length > 0) {
            for (let i = 0; i < props.sItems.length; i++) {
                const iitem = props.sItems[i];
                arrayItems.value.data.push({
                    sindex: i,
                    id: iitem.id,
                    content: iitem.content,
                    type_id: iitem.type_id,
                    description: iitem.description,
                    si_id: iitem.si_id,
                    si_position: iitem.si_position
                });
                arrayItems.value.description = iitem.si_description
            }
        }
    }
    onMounted(() => {
        setDataItems()
    });
    const deleteForm = useForm({});

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
                return axios.delete(route('cms_section_items_destroy', id)).then((res) => {
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
                router.visit(route('cms_section_items',props.section.id), { replace: true, method: 'get' });
            }
        });
    }

    const startEvent = ref(false);
    const addItem = (row, index) => {
        let xitem = {
            sindex: index,
            id: row.id,
            content: row.content,
            type_id: row.type_id,
            description: row.description,
            si_id: row.si_id,
            si_position: row.si_position,
        }
        let ritem = form.items[index];
        ritem.display = false;
        arrayItems.value.data.push(xitem);
    }

    const saveItems = () => {
        router.visit(route('cms_section_items_store'), {
            method: 'post',
            data: arrayItems.value,
            replace: false,
            preserveState: false,
            preserveScroll: false,
            onStart: visit => { startEvent.value = true },
            onFinish: visit => { startEvent.value = false },
            onSuccess: page => {
                Swal2.fire({
                    title: 'Enhorabuena',
                    text: 'Items agregados correctamente',
                    icon: 'success',
                });
            },
        });
    }
</script>

<template>
    <AppLayout title="Resumen">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">CMS</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Secciones</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ section.description }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Items</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="xl:pb-1">
                    <div class="max-w-full overflow-x-auto">
                        <div class="flex">
                            <div class="w-full">
                                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Items Disponibles</h2>
                                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <template v-for="(item, index) in form.items" >
                                            <li v-if="item.display" class="py-3 sm:py-4">
                                                <template v-if="item.type_id == 1">
                                                    <label @click="addItem(item,index)" :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                        <div class="block">
                                                            <img  :src="item.content" style="width: 60px;" />
                                                            <div class="w-full text-sm">{{ item.description }}</div>
                                                            <!-- <a :href="item.content" target="_blank" class="w-full text-sm">{{ item.content }}</a> -->
                                                        </div>
                                                    </label>
                                                </template>
                                                <template v-if="item.type_id == 2">
                                                    
                                                    <label @click="addItem(item,index)" :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                        <div class="block">
                                                            <font-awesome-icon class="mb-2 w-7 h-7 text-sky-500"  :icon="faCirclePlay" />
                                                            <div class="w-full text-sm">{{ item.description }}</div>
                                                            <!-- <a :href="item.content" target="_blank" class="w-full text-sm">{{ item.content }}</a> -->
                                                        </div>
                                                    </label>
                                                </template>
                                                <template v-if="item.type_id == 3">
                                                    
                                                    <label @click="addItem(item,index)" :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                        <div class="block">
                                                            <font-awesome-icon class="mb-2 w-7 h-7 text-sky-500"  :icon="faFileCircleCheck" />
                                                            <div class="w-full text-sm">{{ item.description }}</div>
                                                            <a :href="item.content" target="_blank" class="w-full text-sm">{{ item.content }}</a>
                                                        </div>
                                                    </label>
                                                </template>
                                                <template v-if="item.type_id == 4">
                                                
                                                    <label @click="addItem(item,index)" :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                        <div class="block">
                                                            <div class="w-full text-lg font-semibold">{{ item.content }}</div>
                                                            <div class="w-full text-sm">{{ item.description }}</div>
                                                        </div>
                                                    </label>
                                                </template>

                                            </li>
                                        </template>
                                    </ul>
                                    <Pagination :data="items" />
                                </div>
                            </div>
                            <div class="w-3 px-2"></div>
                            <div class="w-full">
                                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Items Elegidos</h2>
                                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <li v-for="(item, index) in arrayItems.data" class="py-3 sm:py-4">
                                            <template v-if="item.type_id == 1">
                                                <label :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                    <div class="block">
                                                        <img  :src="item.content" style="width: 60px;" />
                                                        <div class="w-full text-sm">{{ item.description }}</div>
                                                        <!-- <a :href="item.content" target="_blank" class="w-full text-sm">{{ item.content }}</a> -->
                                                    </div>
                                                </label>
                                            </template>
                                            <template v-if="item.type_id == 2">
                                                
                                                <label :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                    <div class="block">
                                                        <font-awesome-icon class="mb-2 w-7 h-7 text-sky-500"  :icon="faCirclePlay" />
                                                        <div class="w-full text-sm">{{ item.description }}</div>
                                                        <!-- <a :href="item.content" target="_blank" class="w-full text-sm">{{ item.content }}</a> -->
                                                    </div>
                                                </label>
                                            </template>
                                            <template v-if="item.type_id == 3">
                                                
                                                <label :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                    <div class="block">
                                                        <font-awesome-icon class="mb-2 w-7 h-7 text-sky-500"  :icon="faFileCircleCheck" />
                                                        <div class="w-full text-sm">{{ item.description }}</div>
                                                        <a :href="item.content" target="_blank" class="w-full text-sm">{{ item.content }}</a>
                                                    </div>
                                                </label>
                                            </template>
                                            <template v-if="item.type_id == 4">
                                                
                                                <label :for="'react-option'+index" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                                    <div class="block">
                                                        <div class="w-full text-lg font-semibold">{{ item.content }}</div>
                                                        <div class="w-full text-sm">{{ item.description }}</div>
                                                    </div>
                                                </label>
                                            </template>
                                            <input style="width: 70px;" class="mt-1 mr-2" type="number" v-model="item.si_position">
                                            <button @click="destroyItem(item.si_id)" type="button" class="mr-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-1">Eliminar Item</button>
                                            <template v-if="item.type_id == 5">
                                                <span>{{ item.description }}</span>
                                            </template>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-4">
                                    
                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                    <textarea id="message" v-model="arrayItems.description" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aquí..."></textarea>

                                </div>
                                <div class="mt-4">
                                    <Keypad>
                                        <template #botones>
                                            <PrimaryButton @click="saveItems" :class="{ 'opacity-25': startEvent }" :disabled="startEvent">
                                                <svg v-show="startEvent" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                </svg>
                                                Guardar
                                            </PrimaryButton>
                                            <Link :href="route('cms_section_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                                        </template>
                                    </Keypad>
                                </div>
                            </div>
                        </div>                       
                    </div>

                </div>
            </div>
        </div>
        
    </AppLayout>
</template>
