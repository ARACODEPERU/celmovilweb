<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm, router, Link } from '@inertiajs/vue3';
    import { faGears, faPlus } from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue';
    import DialogModal from '@/Components/DialogModal.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref } from 'vue';
    import swal from 'sweetalert';
    import Keypad from '@/Components/Keypad.vue';
    import ModalLarge from '@/Components/ModalLarge.vue';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import VueMagnifier from '@websitebeaver/vue-magnifier'
    import '@websitebeaver/vue-magnifier/styles.css'
    import Swal2 from 'sweetalert2';
    import esES from 'ant-design-vue/es/locale/es_ES';
    import { 
      ConfigProvider, Dropdown, Menu, MenuItem, Button, Select, Image
    } from 'ant-design-vue';

    const props = defineProps({
        products: {
            type: Object,
            default: () => ({}),
        },
        establishments: {
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
        displayProduct: props.filters.displayProduct == 'false' ? false : true,
    });
    
    const formDetails = useForm({
        usine: '',
        interne: '',
        description: '',
        image: '',
        purchase_prices: '',
        sale_prices:{
            high:'',
            medium: '',
            under:''
        },
        sizes: [{
            size:'',
            quantity: ''
        }],
        stock_min:'',
        stock:'',
        quantity_total:'',
        presentations: null
    });

    const formDelete = useForm({});
    const openModalDetilsProduct = ref(false);
    const openModalEntrada = ref(false);
    const openModalTraslado = ref(false);
    const displayModalPrices = ref(false);

    const showDetailProduct = (product) => {

        formDetails.interne = product.interne;
        formDetails.description = product.description;
        formDetails.purchase_prices = product.purchase_prices;
        formDetails.sale_prices = JSON.parse(product.sale_prices);
        formDetails.sizes = JSON.parse(product.sizes);
        formDetails.stock_min = product.stock_min;
        formDetails.stock = product.stock;
        formDetails.quantity_total=0;
        formDetails.presentations=product.presentations;
        if(product.presentations){
          formDetails.sizes.forEach(size => {
              formDetails.quantity_total+= parseFloat(size.quantity); //*1 para parsear a numero
          });
        }else{
          formDetails.quantity_total = product.stock
        }

        openModalDetilsProduct.value = true;
    }

    function destroy(id) {
        if (confirm("¿Estás seguro de que quieres eliminar?")) {
            formDelete.delete(route('products.destroy', id));
        }

    }
    const closeModalDetailsProduct = () => {
      openModalDetilsProduct.value = false;
    }

    const closeModalEntradaSalida = () => {
      openModalEntrada.value = false;
    }

    const closeModalTrasladoMercaderia = () => {
      openModalTraslado.value = false;
    }

    const openModalEntradaSalida = (d) => {

      formInput.type = d;
      openModalEntrada.value = true;
    }

    const formInput = useForm({
        type: 1,
        motion: 'purchase',
        product_id: '',
        presentations: false,
        stock: null,
        local_id: 1,
        local_id_destino:1,
        local_id_origen:1,
        quantity: null,
        description: '',
        sizes: [{
            size:'',
            quantity: ''
        }],
    });

    const dataProducts= useForm({
      products: [],
      search:''
    });

    const dataProductByLocal= useForm({
      product: []
    });

    const searchProducts = async () => {
        axios.post(route('search_product_all'), dataProducts ).then((res) => {
          dataProducts.products = res.data.products;
          document.getElementById('resultSearch').style.display = 'block';
        });
    };


    const saveProductInput = () => {
      formInput.post(route('input_products'), {
          errorBag: 'saveProductInput',
          preserveScroll: true,
          onSuccess: () => {
            formInput.reset()
            dataProducts.search = null;
            swal('Se registro correctamente.');
          },
      });
    }

    const selectProducts = (product) => {
      formInput.product_id = product.id;
      formInput.presentations = product.presentations == 1 ? true : false ;
      formInput.stock = product.stock;
      dataProducts.search = product.interne+ ' - '+ product.description;
      document.getElementById('resultSearch').style.display = 'none';
    }

    const addSize = () => {
        let ar = {
            size:'',
            quantity: ''
        };
        formInput.sizes.push(ar);
    };

    const removeSize = (index) => {
        if(index>0){
          formInput.sizes.splice(index,1);
        }
    };



    const dataPrices= useForm({
        product: {},
        product_name: '',
        product_id:'',
        locals:[]
    });

    const openModalPrices = (product) => {
      dataPrices.product = product;
      dataPrices.product_id = product.id;
      dataPrices.product_name = product.interne+ ' - ' +product.description;

      axios.get(route('product_prices',product.id)).then((objeto) => {
        if (Object.keys(objeto.data).length === 0) {
          for (let propiedad in props.establishments) {
            dataPrices.locals[propiedad] = {
              local_id: props.establishments[propiedad]['id'],
              local_name: props.establishments[propiedad]['description'],
              local_price1: JSON.parse(product.sale_prices)['high'],
              local_price2: JSON.parse(product.sale_prices)['medium'],
              local_price3: JSON.parse(product.sale_prices)['under']
            }
          }
        } else {
          for (let propiedad in objeto.data) {
            dataPrices.locals[propiedad] = {
              local_id: objeto.data[propiedad]['local_id'],
              local_name: objeto.data[propiedad]['description'],
              local_price1: objeto.data[propiedad]['high'],
              local_price2: objeto.data[propiedad]['medium'],
              local_price3: objeto.data[propiedad]['under']
            }
          }
        }
      });
      displayModalPrices.value = true;
    }

    const closeModalPrices = () => {
      displayModalPrices.value = false;
    }

    const saveProductPrices = () => {
      dataPrices.post(route('product_prices_establishments'), {
          errorBag: 'saveProductPrices',
          preserveScroll: true,
          onSuccess: () => {
            swal('Precios registrados correctamente');
          },
      });
    }

    const formReLocate = useForm({
        product_id: '',
        product_full_name: '',
        local_id_origin: 1,
        local_id_destiny: '',
        description:'',
        presentations: false,
        quantity: null,
        stock: null,
        sizes: []
    });

    const openModalTrasladoMercaderia = (product) => {
        formReLocate.product_id = product.id;
        formReLocate.presentations = product.presentations;
        formReLocate.product_full_name = product.interne+' - '+product.description
        if(product.presentations){
          getProductByLocal();
        }else{
          formReLocate.stock = product.stock;
        }
        
        openModalTraslado.value = true;
    }

    function getProductByLocal(){
        formReLocate.sizes = [];
        axios.post(route('get_product_by_local'), formReLocate ).then((res) => {
            let dataSizes = res.data;
            for (let i = 0; i < dataSizes.length; i++) {
              formReLocate.sizes[i] = dataSizes[i];
            }
        });
    }

    function saveRelocate(){
      formReLocate.post(route('relocate_product_sizes'), {
          errorBag: 'saveRelocate',
          preserveScroll: true,
          onSuccess: () => {
            swal('Traslado registrados correctamente');
            formReLocate.reset();
            openModalTraslado.value = false;
          },
      });
    }

    const displayModalImport = ref(false);

    const openModalImport = () => {
      displayModalImport.value = true;
    }
    const closeModalImport = () => {
      displayModalImport.value = false;
    }

    const formImport = useForm({
        file: null
    });

    const saveImport = async () => {

      if(formImport.file){
        Swal2.fire({
          imageUrl: '/img/loading-70.gif',
          imageHeight: 120,
          imageAlt: 'Cargando',
          showConfirmButton: false,
          allowOutsideClick: false
        });

        displayModalImport.value = false;
        
        try {
          const response = await axios.post(route('import_product_data'), formImport, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });
          formImport.reset()
          Swal2.fire({ 
            html: `total de registros: ${response.data.total}` 
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = route('product.index');
            }
          })
        } catch (error) {
            console.log(error)
        } 
      }else{
        formImport.errors.file = 'Seleccionar Archivo';
      }
    }

    const getProductsServices = (val) => {
      form.displayProduct = val;
      form.get(route('products.index'));
    }
</script>
<template>
    <AppLayout title="Productos">
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
                  <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ventas</span>
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
          <!-- Breadcrumb End -->

          <!-- ====== Table Section Start -->
          <div class="flex flex-col gap-10">
            <!-- ====== Table One Start -->
            <div class="rounded-sm border border-stroke bg-white pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark">
              <div class="border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                  <li class="mr-2">
                      <a @click="getProductsServices(true)" href="#" :class="[form.displayProduct ? 'border-b-2 text-blue-600' : 'border-transparent']" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        <img src="/img/24px/orden.png" class="mr-1" />Productos
                      </a>
                  </li>
                  <li class="mr-2">
                      <a @click="getProductsServices(false)" href="#" :class="[!form.displayProduct ? 'border-b-2 text-blue-600' : 'border-transparent']" class="inline-flex p-4  rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group" aria-current="page">
                        <img src="/img/24px/public-service.png" class="mr-1" />Servicios
                      </a>
                  </li>
                </ul>
              </div>
              <div class="w-full p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl dark:border-gray-600 dark:bg-gray-700">
                <div class="grid grid-cols-3">
                  <div class="col-span-3 sm:col-span-1">
                    <form @submit.prevent="form.get(route('products.index'))">
                      <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input v-model="form.search" type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar productos">
                        </div>
                    </form>
                  </div>
                  <div class="col-span-3 sm:col-span-2">
                    <Keypad>
                      <template #botones>
                        <template v-if="form.displayProduct" >
                          <button v-can="'productos_salida'" @click="openModalEntradaSalida(0)" type="button" class="mr-1 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Salidas</button>
                          <button v-can="'productos_entrada'" @click="openModalEntradaSalida(1)" type="button" class="mr-1 inline-block px-6 py-2.5 bg-blue-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-800 hover:shadow-lg  focus:bg-green-600 focus:shadow-lg focus:outline-none  focus:ring-0 focus:ring-blue-300 active:shadow-lg dark:bg-blue-600 dark:hover:bg-blue-700 transition duration-150 ease-in-out">Entradas</button>
                          <button v-can="'productos_entrada'" @click="openModalImport()" type="button" class="mr-1 inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-800 hover:shadow-lg focus:ring-green-300  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition duration-150 ease-in-out" >Importar</button>
                          <Link v-can="'productos_nuevo'" :href="route('products.create')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Nuevo
                          </Link>
                        </template>
                        <template v-else >
                          <Link v-can="'productos_nuevo'" :href="route('create_service')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Nuevo 
                          </Link>
                        </template>
                      </template>
                    </Keypad>
                  </div>
                </div>
              </div>
              <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                      <th class="w-20 py-2 px-2 text-sm font-medium text-black dark:text-white xl:pl-11">
                          Acción
                      </th>
                      <th v-if="form.displayProduct" class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                          Imagen
                      </th>
                      <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                          Código
                      </th>
                      <th class="py-2 px-2 text-sm font-medium text-black dark:text-white">
                          Descripción
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(product, index) in products.data" :key="product.id" >
                        <td class="text-center text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                          
                            <Dropdown :placement="'bottomLeft'" arrow>
                                <button class="border py-1.5 px-2 dropdown-button inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm" type="button" @click="toggle">
                                    <font-awesome-icon :icon="faGears" />
                                </button>
                              <template #overlay>
                                <Menu >
                                  <MenuItem>
                                    <Link v-permission="'productos_editar'" :href="route('products.edit',product.id)" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100" >
                                      Editar
                                    </Link>
                                  </MenuItem>
                                  <MenuItem>
                                    <Button type="Link" @click="openModalTrasladoMercaderia(product)">
                                      Mover producto
                                    </Button>
                                  </MenuItem>
                                  <MenuItem>
                                    <Button type="Link">
                                        Imprimir Tiket
                                    </Button>
                                  </MenuItem>
                                  <MenuItem>
                                    <Button @click="openModalPrices(product)" type="Link" >
                                      Precios por Tienda
                                    </Button>
                                  </MenuItem>
                                  <MenuItem v-if="form.displayProduct">
                                    <Button type="Link"  @click="showDetailProduct(product)">
                                      Ver Stock
                                    </Button>
                                  </MenuItem>
                                  <MenuItem>
                                    <Button type="Link" @click="destroy(product.id)" class="text-red-700" >
                                        Eliminar
                                    </Button>
                                  </MenuItem>
                                </Menu>
                              </template>
                            </Dropdown>
                          
                        </td>
                        <td v-if="form.displayProduct" class="w-32 border-b border-stroke py-4 px-4 dark:border-strokedark">
                          <Image
                            :src="product.image"
                            />
                        </td>
                        <td class="text-right text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                            {{ product.interne }}
                        </td>
                        <td class="text-sm border-b border-stroke py-2 px-2 dark:border-strokedark">
                            {{ product.description }}
                        </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5" class="py-4 px-4 dark:border-strokedark">
                        <Pagination :data="products" />
                      </td>
                    </tr>
                  </tfoot>
                </table>
                
              </div>
              
            </div>
           </div>
        </div>
        <ModalLarge :show="openModalDetilsProduct"  @close="closeModalDetailsProduct">
            <template #title>
              {{ formDetails.interne }} - {{ formDetails.description }}
            </template>

            <template #content>
              <table class="border" style="width: 100%;">
                    <thead class="bg-white border-b">
                      <tr class="text-xs text-white bg-blue-700 border-b dark:text-white dark:bg-gray-800">
                        <th v-if="formDetails.presentations" class="text-lg font-medium  px-6 py-4 text-left italic hover:not-italic dark:text-white dark:bg-gray-800">
                          Presentación
                        </th>
                        <th :colspan="formDetails.presentations ? 0 : 2" class="text-lg font-medium  px-6 py-4 text-left italic hover:not-italic dark:text-white dark:bg-gray-800">
                          Cantidad
                        </th>
                        <th v-if="formDetails.sale_prices.high" class="text-lg font-medium  px-6 py-4 text-left italic hover:not-italic dark:text-white dark:bg-gray-800">
                          Precio V. Normal
                        </th>
                        <th v-if="formDetails.sale_prices.medium" class="text-lg font-medium  px-6 py-4 text-left italic hover:not-italic dark:text-white dark:bg-gray-800">
                          Precio V. Medio
                        </th>
                        <th v-if="formDetails.sale_prices.under" class="text-lg font-medium  px-6 py-4 text-left italic hover:not-italic dark:text-white dark:bg-gray-800">
                          Precio V. Minimo
                        </th>
                        <th class="text-lg font-medium  px-6 py-4 text-left italic hover:not-italic dark:text-white dark:bg-gray-800">
                          Precio de Compra
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <template v-if="formDetails.presentations">
                        <tr v-for="(size, index) in formDetails.sizes" :key="formDetails.id"  class="border-b ">
                          <td class="text-right px-6 py-4 text-sm font-medium text-white bg-blue-600  dark:bg-gray-800">
                            {{ size.size }}</td>
                          <td class="text-right text-sm text-white font-light px-6 py-4 bg-blue-700 dark:bg-gray-800">
                            {{ size.quantity }}
                          </td>
                          <td v-if="formDetails.sale_prices.high" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-600 dark:bg-gray-800">
                            S/. {{ formDetails.sale_prices.high }}
                          </td>
                          <td v-if="formDetails.sale_prices.medium" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-700 dark:bg-gray-800">
                            S/. {{ formDetails.sale_prices.medium ? formDetails.sale_prices.medium : 0 }}
                          </td>
                          <td v-if="formDetails.sale_prices.under" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-600 dark:bg-gray-800">
                            S/. {{ formDetails.sale_prices.under ? formDetails.sale_prices.under : 0 }}
                          </td>
                          <td class="text-right text-sm text-white font-light px-6 py-4 bg-blue-700 dark:bg-gray-800">
                            S/. {{ formDetails.purchase_prices }}
                          </td>
                        </tr>
                      </template>
                      <template v-else>
                        <tr class="border-b ">
                          <td :colspan="formDetails.presentations ? 0 : 2" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-700 dark:bg-gray-800">
                            {{ formDetails.stock }}
                          </td>
                          <td v-if="formDetails.sale_prices.high" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-600 dark:bg-gray-800">
                            S/. {{ formDetails.sale_prices.high ? formDetails.sale_prices.high : 0 }}
                          </td>
                          <td v-if="formDetails.sale_prices.medium" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-700 dark:bg-gray-800">
                            S/. {{ formDetails.sale_prices.medium ? formDetails.sale_prices.medium : 0 }}
                          </td>
                          <td v-if="formDetails.sale_prices.under" class="text-right text-sm text-white font-light px-6 py-4 bg-blue-600 dark:bg-gray-800">
                            S/. {{ formDetails.sale_prices.under ? formDetails.sale_prices.under : 0 }}
                          </td>
                          <td class="text-right text-sm text-white font-light px-6 py-4 bg-blue-700 dark:bg-gray-800">
                            S/. {{ formDetails.purchase_prices }}
                          </td>
                        </tr>
                      </template>

                        <tr class=" border-b">
                          <td class="text-right px-6 py-4 text-sm font-medium bg-blue-600 text-white dark:bg-gray-800">
                              Totales
                          </td>
                          <td class="text-right text-sm text-white font-light bg-blue-700 px-6 py-4 dark:bg-gray-800">
                            {{ formDetails.quantity_total }}
                          </td>
                          <td v-if="formDetails.sale_prices.high" class="text-right text-sm text-white font-light bg-blue-600 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.sale_prices.high }}
                          </td>
                          <td v-if="formDetails.sale_prices.medium" class="text-right text-sm text-white font-light bg-blue-700 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.sale_prices.medium }}
                          </td>
                          <td v-if="formDetails.sale_prices.under" class="text-right text-sm text-white font-light bg-blue-600 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.sale_prices.under }}
                          </td>
                          <td class="text-right text-sm text-white font-light bg-blue-700 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.purchase_prices }}
                          </td>
                        </tr>

                        <tr class="border-b">
                          <td colspan="2" class="text-right px-6 py-4 text-sm bg-green-700 font-medium text-white dark:bg-gray-800">
                            Ganancias Esperadas
                          </td>
                          <td v-if="formDetails.sale_prices.high" class="text-right text-sm text-white font-light bg-green-700 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.sale_prices.high-(formDetails.quantity_total*formDetails.purchase_prices) }}
                          </td>
                          <td v-if="formDetails.sale_prices.medium" class="text-right text-sm text-white font-light bg-green-700 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.sale_prices.medium-(formDetails.quantity_total*formDetails.purchase_prices) }}
                          </td>
                          <td v-if="formDetails.sale_prices.under" class="text-right text-sm text-white font-light bg-green-700 px-6 py-4 dark:bg-gray-800">
                            S/. {{ formDetails.quantity_total*formDetails.sale_prices.under-(formDetails.quantity_total*formDetails.purchase_prices) }}
                          </td>
                          <td class="text-sm text-white font-light bg-green-700 px-6 py-4 dark:bg-gray-800">
                            <!-- no usar esta clase whitespace-nowrap -->
                          </td>
                        </tr>
                    </tbody>
                  </table>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModalDetailsProduct">
                    Cancel
                </SecondaryButton>
            </template>
        </ModalLarge>

        <DialogModal
          :show="openModalEntrada"
          @close="closeModalEntradaSalida"

          >
            <template #title>
              {{ formInput.type == 1 ? 'Entrada' : 'Salida' }} de producto
            </template>

            <template #content>
                <div class="mt-4 mb-1">
                  <div style="position: relative;">
                    <div class="bg-white dark:bg-gray-900">
                      <label for="table-search" class="sr-only">Search</label>
                      <div class="relative mt-1">
                          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                          </div>
                          <input @keyup.enter="searchProducts" v-model="dataProducts.search" autocomplete="off" type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar producto">
                      </div>
                      <InputError :message="formInput.errors.product_id" class="mt-2" />
                    </div>
                    <div class="mt-1" id="resultSearch" style="position: absolute;width: 100%;z-index: 1000000;display: none;">
                        <div style="height: 300px;overflow-y: auto;">
                            <table class="min-w-full" >
                                <tbody>
                                    <tr v-for="(product, index) in dataProducts.products" class="border-b bg-gray-100 boder-gray-900" style="cursor: pointer;">
                                        <td @click="selectProducts(product)" class="text-sm font-medium px-6 py-4 whitespace-nowrap">
                                            {{ product.interne }} - {{ product.description }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="col-span-2 sm:col-span-1">
                    <InputLabel for="stablishment" value="Establecimiento" />
                    <select v-model="formInput.local_id" id="stablishment" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <template v-for="(establishment, index) in props.establishments" :key="index">
                          <option :value="establishment.id">{{ establishment.description }}</option>
                      </template>
                    </select>
                    <InputError :message="formInput.errors.local_id" class="mt-2" />
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <InputLabel for="description" value="Descripción" />
                    <TextInput
                        id="description"
                        v-model="formInput.description"
                        type="text"
                        class="block w-full mt-1"
                        autofocus
                    />
                    <InputError :message="formInput.errors.description" class="mt-2" />
                  </div>
                  <template v-if="formInput.presentations">
                    <div class="col-span-6 sm:col-span-6">
                        <label>
                            Tallas
                            <button @click="addSize" type="button" class="inline-block px-6 py-2.5 bg-transparent text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:text-blue-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring-0 active:bg-gray-200 transition duration-150 ease-in-out">Agregar</button>
                        </label>
                        <div v-for="(item, index) in formInput.sizes" v-bind:key="index">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="padding: 4px;">
                                        <div class="col-span-3 sm:col-span-2">
                                            <InputLabel value="Talla" />
                                            <TextInput
                                                v-model="item.size"
                                                type="text"
                                                class="block w-full mt-1"
                                                autofocus
                                            />
                                            <InputError :message="formInput.errors[`sizes.${index}.size`]" class="mt-2" />
                                        </div>
                                    </td>
                                    <td style="padding: 4px;">
                                        <div class="col-span-3 sm:col-span-2">
                                            <InputLabel value="Cantidad" />
                                            <TextInput
                                                v-model="item.quantity"
                                                type="number"
                                                class="block w-full mt-1"
                                                autofocus
                                            />
                                            <InputError :message="formInput.errors[`sizes.${index}.quantity`]" class="mt-2" />
                                        </div>
                                    </td>
                                    <td style="padding: 4px;" valign="bottom">
                                        <button @click="removeSize(index)" type="button" class="inline-block rounded-full bg-blue-600 text-white leading-normal uppercase shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-9 h-9">
                                            <font-awesome-icon :icon="faTrashAlt" />
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                  </template>
                  <template v-else>
                    <div class="col-span-2 sm:col-span-1">
                      <InputLabel for="stock" value="Stock Actual" />
                      <TextInput
                          id="stock"
                          v-model="formInput.stock"
                          type="number"
                          class="block w-full mt-1"
                          disabled
                      />
                      <InputError :message="formInput.errors.stock" class="mt-2" />
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <InputLabel for="description" value="Cantidad en Movimiento" />
                      <TextInput
                          id="quantity"
                          v-model="formInput.quantity"
                          type="number"
                          class="block w-full mt-1"
                      />
                      <InputError :message="formInput.errors.quantity" class="mt-2" />
                    </div>
                  </template>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModalEntradaSalida">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': formInput.processing }"
                    :disabled="formInput.processing"
                    @click="saveProductInput"
                >
                    Guardar
                </DangerButton>
            </template>
        </DialogModal>

        <DialogModal :show="openModalTraslado" @close="closeModalTrasladoMercaderia">
            <template #title>
              Traslado de {{ formReLocate.product_full_name }}
            </template>

            <template #content>
                <div class="mt-4 mb-1">
                </div>
                <div class="grid grid-cols-3 gap-4">
                  <div class="col-span-3 sm:col-span-1">
                    <InputLabel for="stablishment" value="Establecimiento Origen" />
                    <select v-model="formReLocate.local_id_origin"  v-on:change="getProductByLocal()" id="stablishment" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <template v-for="(establishment, kk) in props.establishments" :key="kk">
                          <option :value="establishment.id">{{ establishment.description }}</option>
                      </template>
                    </select>
                    <InputError :message="formReLocate.errors.local_id_origin" class="mt-2" />
                  </div>
                                                                                                                        <!-- Destino-->
                  <div class="col-span-3 sm:col-span-1">
                    <InputLabel for="stablishment" value="Establecimiento Destino" />
                    <select v-model="formReLocate.local_id_destiny" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <template v-for="(establishment, gg) in props.establishments" :key="gg">
                          <option :value="establishment.id">{{ establishment.description }}</option>
                      </template>
                    </select>
                    <InputError :message="formReLocate.errors.local_id_destiny" class="mt-2" />
                  </div>

                  <div class="col-span-3 sm:col-span-1">
                    <InputLabel class="mb-1" for="description" value="Descripción o Motivo" />
                    <TextInput
                        id="description"
                        v-model="formReLocate.description"
                        type="text"
                        autofocus
                    />
                    <InputError :message="formReLocate.errors.description" class="mt-2" />
                  </div>
                  <div v-if="formReLocate.presentations" class="col-span-3">
                      <label>
                          Tallas Disponibles en el local de origen
                      </label>
                      <div v-for="(item, index) in formReLocate.sizes" v-bind:key="index">
                          <table style="width: 100%;">
                              <tr>
                                  <td style="padding-right: 4px;">
                                    <InputLabel value="Talla" />
                                    <TextInput
                                    disabled
                                        v-model="item.size"
                                        type="text"
                                        class="bg-gray-200 block w-full mt-1"
                                        
                                    />

                                  </td>
                                  <td style="padding-right: 4px;padding-left: 4px;">
                                    <InputLabel value="Cantidad" />
                                    <TextInput

                                      disabled
                                      v-model="item.quantity"
                                      type="number"
                                      class="bg-gray-200 block w-full mt-1"
                                        
                                    />
                                  </td>
                                  <td style="padding-left: 4px;" valign="bottom">
                                      <InputLabel value="Cantidad a trasladar" />
                                      <TextInput
                                      v-model="item.quantity_relocate"
                                          type="text"
                                          class="block w-full mt-1"
                                          autofocus/>
                                      <InputError :message="formReLocate.errors[`sizes.${index}.quantity_relocate`]" class="mt-2" />
                                  </td>
                              </tr>
                          </table>
                      </div>
                  </div>
                  
                  <div v-else class="col-span-3">
                    <table style="width: 100%;">
                      <tr>
                        <td style="padding-right: 4px;" valign="bottom">
                          <InputLabel value="Stock" />
                          <TextInput
                            v-model="formReLocate.stock"
                            type="text"
                            class="block w-full mt-1"
                            disabled
                            />
                            <InputError :message="formReLocate.errors.quantity" class="mt-2" />
                        </td>
                        <td style="padding-left: 4px;" valign="bottom">
                          <InputLabel value="Cantidad a trasladar" />
                          <TextInput
                            v-model="formReLocate.quantity"
                            type="text"
                            class="block w-full mt-1"
                            autofocus/>
                            <InputError :message="formReLocate.errors.quantity" class="mt-2" />
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
            </template>

            <template #footer>
                <DangerButton
                    :class="{ 'opacity-25': formReLocate.processing }"
                    :disabled="formReLocate.processing"
                    @click="saveRelocate()"
                >
                  <svg v-show="formReLocate.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                      <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                  </svg>
                  Guardar
                </DangerButton>
                <SecondaryButton class="ml-3" @click="closeModalTrasladoMercaderia()">
                    Cancel
                </SecondaryButton>
            </template>
        </DialogModal>
        <ModalLarge
          :show="displayModalPrices"
          :onClose="closeModalPrices"
        >
          <template #title>
              {{ dataPrices.product_name }}
          </template>
          <template #message>
              Precios Por Tienda
          </template>
          <template #content>
            <div class="flex flex-col">
              <div class="overflow-y-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                    <table class="min-w-full text-sm font-light">
                      <thead class="border font-medium dark:border-neutral-500">
                        <tr>
                          <th scope="col" class="px-6 py-2">Tienda</th>
                          <th scope="col" class="px-6 py-2">P. Normal</th>
                          <th scope="col" class="px-6 py-2">P. Medio</th>
                          <th scope="col" class="px-6 py-2">P. Minimo</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(local, fe) in dataPrices.locals" :key="fe"
                          class="border dark:border-neutral-500"
                          >
                          <td class=" px-6 py-2">{{  local.local_name  }}</td>
                          <td class=" px-6 py-2">
                            <input
                              v-model="local.local_price1"
                              type="text" class="text-right block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <InputError :message="dataPrices.errors[`sizes.${index}.local_price1`]" class="mt-2" />
                          </td>
                          <td class=" px-6 py-2">
                            <input
                            v-model="local.local_price2"
                            type="text" class="text-right block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <InputError :message="dataPrices.errors[`sizes.${index}.local_price2`]" class="mt-2" />
                          </td>
                          <td class=" px-6 py-2">
                            <input
                            v-model="local.local_price3"
                            type="text" class="text-right block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <InputError :message="dataPrices.errors[`sizes.${index}.local_price3`]" class="mt-2" />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </template>
          <template #buttons>
            <DangerButton
                class="mr-3"
                @click="saveProductPrices()"
            >
                Guardar
            </DangerButton>
          </template>
        </ModalLarge>

        <ModalSmall :show="displayModalImport" :onClose="closeModalImport" :icon="'/img/excel.png'">
          <template #title>
            Importar productos
          </template>
          <template #message>
            Solo acepta documentos EXCEL
          </template>
          <template #content>
            <div class="flex flex-col">
              
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
              <input @input="formImport.file = $event.target.files[0]" accept=".xls, .xlsx"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">.xlsx.</p>
              <InputError :message="formImport.errors.file" class="mt-2" />
            </div>

          </template>
          <template #buttons>
            <DangerButton
                class="mr-3"
                @click="saveImport()"
            >
                Procesar
            </DangerButton>
          </template>
        </ModalSmall>
      </ConfigProvider>
    </AppLayout>
</template>
