<script setup>
    import DialogModal from '@/Components/DialogModal.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import swal from 'sweetalert';
    import { Input } from 'flowbite-vue'

    const props = defineProps({
        displaySearch: {
            type: Boolean,
            default: false
        },
        close: {
            type: Function,
            default: false
        }
    });

    const displayModal = ref(false);

    const formScaner = useForm({
        scaner: false
    });
    const form = useForm({
        search: null,
        products: [],
        product: {},
        data:{
            id:'',
            interne: '',
            stock:'',
            description:'',
            price:'',
            size:'',
            quantity: 1,
            discount: 0,
            size_quantity: 0
        }
    });

    const displayResultSearch = ref(false);
    const searchProducts = async () => {
        if(formScaner.scaner){
            axios.post(route('search_scaner_product'), form ).then((response) => {
                if(response.data.success){
                    displayModal.value = true;
                    form.products = [];
                    form.product = response.data.product;
                    form.data.id = response.data.product.id;
                    form.data.interne = response.data.product.interne;
                    form.data.stock = response.data.product.stock;
                    form.data.description = response.data.product.description;
                    form.data.price = null;
                    form.data.total = 0;
                    form.data.quantity = 1;
                    form.data.discount = 0;
                    form.search = null;
                    
                }else{
                    swal(response.data.message);
                }
                
            });
        }else{
            axios.post(route('search_product'), form ).then((response) => {
                if(response.data.success){
                    form.products = response.data.products;
                    displayResultSearch.value = true;
                }else{
                    swal(response.data.message);
                }
                
            });
        }
    };
    const closeModalSelectProduct  = () => {
        displayModal.value = false;
    }
    const openModalSelectProduct = async (product) => {
        displayModal.value = true;
        displayResultSearch.value = false;
        form.products = [];
        form.product = product;
        form.data.id = product.id;
        form.data.interne = product.interne;
        form.data.stock = product.stock;
        form.data.description = product.description;
        form.data.price = product.purchase_prices;
        form.data.total = 0;
        form.data.quantity = 1;
        form.data.discount = 0;
        form.search = null;
    }

    const emit = defineEmits(['eventdata']);

    const addProduct = (pre) => {
        if(form.data.stock > 0 && form.data.stock >= form.data.quantity){
            if (pre){
                if(form.data.size){
                    if(form.data.price){
                        let total = parseFloat(form.data.quantity)*(parseFloat(form.data.price)-parseFloat(form.data.discount))
                        form.data.total = total;
                        let data = {
                            id: form.data.id,
                            interne: form.data.interne,
                            description: form.data.description + ' Talla-'+form.data.size,
                            is_product: form.product.is_product == 1 ? true : false,
                            unit_type: form.product.type_unit_measure_id,
                            quantity: form.data.quantity,
                            unit_price: form.data.price,
                            discount: form.data.discount,
                            total: form.data.total,
                            afe_igv: form.product.type_sale_affectation_id,
                            presentations: pre,
                            size: form.data.size,
                            m_igv: 0,
                            v_sale: 0,
                            icbper: false
                        }
                        emit('eventdata',data);
                        displayModal.value = false;
                        form.data.size = null;
                        displayResultSearch.value = false;
                    }else{
                        swal('Seleccionar Precio')
                    }
                }else{
                    swal('Seleccionar Talla')
                }
            }else{
                if(form.data.price){
                    let total = parseFloat(form.data.quantity)*(parseFloat(form.data.price)-parseFloat(form.data.discount))
                    form.data.total = total;
                    let data = {
                        id: form.data.id,
                        interne: form.data.interne,
                        description: form.data.description,
                        is_product: form.product.is_product == 1 ? true : false,
                        unit_type: form.product.type_unit_measure_id,
                        quantity: form.data.quantity,
                        unit_price: form.data.price,
                        discount: form.data.discount,
                        total: form.data.total.toFixed(2),
                        afe_igv: form.product.type_sale_affectation_id,
                        presentations: pre,
                        m_igv: 0,
                        v_sale: 0,
                        icbper: false
                    }
                    emit('eventdata',data);
                    displayModal.value = false;
                    form.data.size = null;
                    displayResultSearch.value = false;
                }else{
                    swal('Seleccionar Precio')
                }
            }
        }else{
            swal('Stock insuficiente')
        }
    }
</script>


<template>

    <div v-show="displaySearch" style="min-width: 600px;max-width: 600px;" class="absolute z-99 mt-1 bg-white border border-gray-400 shadow w-60 dark:bg-gray-700">
        <div class="p-4">
            <form @submit.prevent="searchProducts()">
                <!-- <div class="flex">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="flex items-center mr-4">
                        <input v-model="formScaner.scaner" id="scaner" type="checkbox" value="" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="scaner" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Scaner</label>
                    </div>
                    <div class="relative w-full">
                        <input v-model="form.search" autocomplete="off" type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Buscar por código o descripción..." required>
                        <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div> -->
                <label for="input-group-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input v-model="form.search" type="text" id="input-group-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search user">
                </div>
            </form>
            
        </div>
        <ul v-show="displayResultSearch" id="result" class="h-48 px-4 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200">
            <li v-for="(product, index) in form.products">
                <div @click="openModalSelectProduct(product)" style="cursor: pointer;" class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" :src="'/storage/'+product.image" :alt="product.interne">
                    </div>
                    <div class="text-left flex-1 min-w-0 ml-2">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ product.interne }}
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ product.description }}
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        Stock {{ product.stock }}
                    </div>
                </div>
            </li>
        </ul>
        <a @click="close" href="#" type="button" class="flex items-center p-2.5 text-sm font-medium text-red-600 border-t border-gray-200 rounded-b-lg bg-gray-50 dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-red-500 hover:underline">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                fill-rule="evenodd"
                d="M5.293 4.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
                ></path>
            </svg>
            Cancelar
        </a>
    </div>

    
    <DialogModal 
        :show="displayModal" 
        @close="closeModalSelectProduct"
    >
        <template #title>
            Detalles del Producto
        </template>
        <template #content>
            <div class="grid grid-cols-3">
                <div class="col-span-1">
                    <div class="flex flex-wrap justify-center p-4">
                        <img
                        :src="'/storage/'+form.product.image"
                        class="p-1 bg-white border rounded max-w-sm"
                        :alt="form.product.description"
                        style="width: 100%;"
                        />
                    </div>
                </div>
                <div class="col-span-2">
                    <h4>{{ form.product.interne  }} - {{ form.product.description  }}</h4>
                    <p class="my-4">Stock Actual : {{ form.data.stock  }}</p>
                    <div class="mb-4">
                        <Input
                            v-model="form.data.price"
                            placeholder="0.00"
                            label="Precio de compra"
                        />
                    </div>
                    <div v-show="form.product.presentations" class="mb-4">
                        <label for="size" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tallas Disponibles
                        </label>
                        <div class="flex">
                            <div v-if="!form.product.local_sizes">
                                <template v-for="(item, key) in JSON.parse(form.product.sizes)">
                                    <div class="form-check">
                                        <input :disabled="item.quantity == 0 ? '' : disabled" v-model="form.data.size" :value="item.size" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="sizes" :id="'size'+ key">
                                        <label :class="item.quantity == 0 ? 'text-gray-500': 'text-gray-800'" class="form-check-label inline-block" :for="'size'+ key ">
                                            Talla: {{ item.size }} / Cantidad: {{ item.quantity }}
                                        </label>
                                    </div>
                                </template>
                            </div>
                            <div v-else>
                                <template v-for="(item, key) in JSON.parse(form.product.local_sizes)">
                                    <div class="form-check">
                                        <input :disabled="item.quantity == 0 ? '' : disabled" v-model="form.data.size" :value="item.size" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="sizes" :id="'size'+ key">
                                        <label :class="item.quantity == 0 ? 'text-gray-500': 'text-gray-800'" class="form-check-label inline-block" :for="'size'+ key ">
                                            Talla: {{ item.size }} / Cantidad: {{ item.quantity }}
                                        </label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cantidad compra
                        </label>
                        <input v-model="form.data.quantity" type="number" id="quantity" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <DangerButton
                class="mr-3"
                @click="addProduct(form.product.presentations)"
            >
                Agregar
            </DangerButton>
            <SecondaryButton @click="closeModalSelectProduct">
                Cancel
            </SecondaryButton>
        </template>
    </DialogModal>
</template>