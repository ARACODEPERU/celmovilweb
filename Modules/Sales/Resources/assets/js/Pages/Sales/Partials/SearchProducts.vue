<script setup>
    import DialogModal from '@/Components/DialogModal.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import swal from 'sweetalert';
    import NumberInput from '@/Components/NumberInput.vue';


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
        form.data.price = JSON.parse(product.sale_prices).high;
        form.data.total = 0;
        form.data.quantity = 1;
        form.data.discount = 0;
        form.search = null;
    }

    const emit = defineEmits(['eventdata']);

    const addProduct = (pre) => {
        if (pre){
            if(form.data.size){
                if(form.data.price){
                    let total = parseFloat(form.data.quantity)*(parseFloat(form.data.price)-parseFloat(form.data.discount))
                    form.data.total = total.toFixed(2);
                    let data = {
                        id: form.data.id,
                        interne: form.data.interne,
                        description: form.data.description,
                        price: form.data.price,
                        total: form.data.total,
                        quantity: form.data.quantity,
                        size: form.data.size,
                        discount: form.data.discount,
                        presentations: pre
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
                form.data.total = total.toFixed(2);
                let data = {
                    id: form.data.id,
                    interne: form.data.interne,
                    description: form.data.description,
                    price: form.data.price,
                    total: form.data.total,
                    quantity: form.data.quantity,
                    size: form.data.size,
                    discount: form.data.discount,
                    presentations: pre
                }
                emit('eventdata',data);
                displayModal.value = false;
                form.data.size = null;
                displayResultSearch.value = false;
            }else{
                swal('Seleccionar Precio')
            }
        }
        
    }
</script>


<template>
    <div style="position: relative;">
        <form @submit.prevent="searchProducts()">
            <div class="flex">
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
            </div>
        </form>
        <div v-show="displayResultSearch" id="result" style="position: absolute; width: 100%;z-index: 999;">
            <div class="mt-1 border border-stroke" style="max-height: 100%;overflow-y: auto;">
                <ul class="max-w-md divide-y bg-white">
                    <li v-for="(product, index) in form.products" class="p-4 border-b border-stroke bg-gray-100 pb-3 sm:pb-4 dark:border-strokedark dark:bg-boxdark" >
                        <div @click="openModalSelectProduct(product)" style="cursor: pointer;" class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" :src="'/storage/'+product.image" :alt="product.interne">
                            </div>
                            <div class="flex-1 min-w-0 ml-2">
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
                    <li class="flex justify-end">
                        <button @click="displayResultSearch = false" class="right-2 flex items-center justify-center w-8 h-8 text-red-500 hover:text-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                fill-rule="evenodd"
                                d="M5.293 4.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
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
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Precios Disponibles
                        </label>
                        <div class="flex">
                            <div v-if="!form.product.local_prices">
                                <div v-if="JSON.parse(form.product.sale_prices).high"  class="form-check">
                                    <input v-model="form.data.price" :value="JSON.parse(form.product.sale_prices).high" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                                        Precio Normal {{ JSON.parse(form.product.sale_prices).high  }}
                                    </label>
                                </div>
                                <div v-if="JSON.parse(form.product.sale_prices).medium" class="form-check">
                                    <input v-model="form.data.price" :value="JSON.parse(form.product.sale_prices).medium" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                                        Precio Medio {{ JSON.parse(form.product.sale_prices).medium  }}
                                    </label>
                                </div>
                                <div v-if="JSON.parse(form.product.sale_prices).under" class="form-check">
                                    <input v-model="form.data.price" :value="JSON.parse(form.product.sale_prices).under" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault3">
                                        Precio Minimo {{ JSON.parse(form.product.sale_prices).under  }}
                                    </label>
                                </div>
                            </div>
                            <div v-else>
                                <div class="form-check">
                                    <input v-model="form.data.price" :value="JSON.parse(form.product.local_prices).high" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                                        Precio Normal {{ JSON.parse(form.product.local_prices).high  }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input v-model="form.data.price" :value="JSON.parse(form.product.local_prices).medium" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                                        Precio Medio {{ JSON.parse(form.product.local_prices).medium  }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input v-model="form.data.price" :value="JSON.parse(form.product.local_prices).under" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault3">
                                        Precio Minimo {{ JSON.parse(form.product.local_prices).under  }}
                                    </label>
                                </div>
                            </div>
                        </div>
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
                            Cantidad a vender
                        </label>
                        <input v-model="form.data.quantity" type="number" id="quantity" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Descuento
                        </label>
                        <NumberInput
                            v-model="form.data.discount"
                            id="discount"
                        ></NumberInput>
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