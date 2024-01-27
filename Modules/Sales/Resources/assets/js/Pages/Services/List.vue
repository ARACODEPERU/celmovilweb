<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm, router, Link } from '@inertiajs/vue3';
    import { faGears, faPlus } from "@fortawesome/free-solid-svg-icons";
    import Pagination from '@/Components/Pagination.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref } from 'vue';
    import swal from 'sweetalert';
    import Keypad from '@/Components/Keypad.vue';
    import ModalLarge from '@/Components/ModalLarge.vue';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import VueMagnifier from '@websitebeaver/vue-magnifier';
    import '@websitebeaver/vue-magnifier/styles.css';
    import Swal2 from 'sweetalert2';
    import esES from 'ant-design-vue/es/locale/es_ES';
    import { 
      ConfigProvider, Dropdown, Menu, MenuItem, Button, Select, Image
    } from 'ant-design-vue';
    import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";

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

    const destroyProduct = (id) => {
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
                return axios.delete(route('destroy_service', id)).then((res) => {
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
                router.visit(route('sales_services'), { replace: true, method: 'get' });
            }
        });
    }


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

    function getProductByLocal(){
        formReLocate.sizes = [];
        axios.post(route('get_product_by_local'), formReLocate ).then((res) => {
            let dataSizes = res.data;
            for (let i = 0; i < dataSizes.length; i++) {
              formReLocate.sizes[i] = dataSizes[i];
            }
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

</script>
<template>
    <AppLayout title="Servicios">
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
              <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
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
                          <button v-can="'sale_productos_importar'" @click="openModalImport()" type="button" class="mr-1 inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-800 hover:shadow-lg focus:ring-green-300  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition duration-150 ease-in-out" >Importar</button>
                          <Link v-can="'productos_nuevo'" :href="route('create_service')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Nuevo 
                          </Link>
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
                      <th class="text-center py-2 px-2 text-sm font-medium text-black dark:text-white">
                          Código
                      </th>
                      <th class="text-left py-2 px-2 text-sm font-medium text-black dark:text-white">
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
                                    <Link v-permission="'sale_servicios_editar'" :href="route('sales_services_edit',product.id)" class="text-left block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100" >
                                      Editar
                                    </Link>
                                  </MenuItem>

                                  <MenuItem>
                                    <Button @click="openModalPrices(product)" type="Link" >
                                      Precios por Tienda
                                    </Button>
                                  </MenuItem>

                                  <MenuItem>
                                    <Button type="Link" @click="destroyProduct(product.id)" class="text-red-700" >
                                        Eliminar
                                    </Button>
                                  </MenuItem>
                                </Menu>
                              </template>
                            </Dropdown>
                          
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
