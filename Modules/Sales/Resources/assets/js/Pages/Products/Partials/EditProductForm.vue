<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { library } from "@fortawesome/fontawesome-svg-core";
import { faTrashAlt, faPlus } from "@fortawesome/free-solid-svg-icons";
import Keypad from '@/Components/Keypad.vue';
import ModalCropperImage from './ModalCropperImage.vue';
import swal from 'sweetalert';
import { watchEffect, defineComponent, ref, onMounted } from 'vue';

import { 
    ConfigProvider, Divider, Space, Button, Select, Input, message, TreeSelect
} from 'ant-design-vue';

import esES from 'ant-design-vue/es/locale/es_ES';

const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Object,
        default: () => ({}),
    },
    brands: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    usine: props.product.usine,
    interne: props.product.interne,
    description: props.product.description,
    image: props.product.image,
    imageNew: '',
    purchase_prices: props.product.purchase_prices,
    sale_prices: JSON.parse(props.product.sale_prices),
    sizes: JSON.parse(props.product.sizes),
    presentations: props.product.presentations == 1 ? true : false,
    category_id: props.product.category_id,
    brand_id: props.product.brand_id
});

const editProduct = () => {
    form.put(route('products.update', props.product.id), {
        errorBag: 'editProduct',
        preserveScroll: true,
        onSuccess: () => {
            swal('Producto actualizada con éxito');
        }
    });
};

const getDataProductImage = (data) => {
    form.image = data.product.image;
}

library.add(faTrashAlt);

const categoriesData = ref([]);
const brandsData = ref([]);

onMounted(()=>{
    // cuando las categorias no tiene sub niveles
    // categoriesData.value = props.categories.map(item => ({ value: item.id, label: item.description }));
    categoriesData.value = props.categories.map((obj) => ({
        value: obj.id,
        label: obj.description,
        children: obj.subcategories.map(item => ({ value: item.id, label: item.description }))
    }));
    brandsData.value = props.brands.map(item => ({ value: item.id, label: item.description }));
});

const VNodes = defineComponent({
  props: {
    vnodes: {
      type: Object,
      required: true,
    },
  },
  render() {
    return this.vnodes;
  },
});

const formCategory = ref({
    id: null,
    description: null,
    loading: false
});

const formBrand = ref({
    id: null,
    description: null,
    loading: false
});

const addCategory = () => {
    if(formCategory.value.description){
        formCategory.value.loading = true;
        axios.post(route('sale_category_product_store', formCategory.value)).then((res) => {
            if (!res.data.success) {
                message.error('No se pudo registrar');
            }else{
                message.success('Se registró correctamente');
                categoriesData.value.push({
                    value: res.data.category.id,
                    label: res.data.category.description 
                })
            }
        }).then(() => {
            formCategory.value.description = null;
            formCategory.value.loading = false;
        });
    }
}

const addBrand = () => {
    if(formBrand.value.description){
        formBrand.value.loading = true;
        axios.post(route('sale_brand_product_store', formBrand.value)).then((res) => {
            if (!res.data.success) {
                message.error('No se pudo registrar');
            }else{
                message.success('Se registró correctamente');
                brandsData.value.push({
                    value: res.data.brand.id,
                    label: res.data.brand.description 
                })
            }
        }).then(() => {
            formBrand.value.description = null;
            formBrand.value.loading = false;
        });
    }
}

</script>

<template>
    <FormSection @submitted="editProduct">
        <template #title>
            Producto Detalles
        </template>

        <template #description>
            Crear nuevo producto para realizar ventas
        </template>

        <template #form>
            <ConfigProvider :locale="esES">
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="category_id" value="Categoría" />
                    <!-- cuando la categoria no tiene sub niveles -->
                    <!-- <Select
                        id="category_id"
                        v-model:value="form.category_id"
                        placeholder="Seleccionar Categoría"
                        style="width: 100%"
                        :options="categoriesData"
                    >
                        <template #dropdownRender="{ menuNode: menu }">
                            <VNodes :vnodes="menu" />
                            <Divider style="margin: 4px 0" />
                            <Space style="padding: 4px 8px">
                                <Input ref="inputRef" v-model:value="formCategory.description" />
                                <Button type="text" :loading="formCategory.loading" @click="addCategory">
                                    <template #icon>
                                        <font-awesome-icon :icon="faPlus" class="mr-1" />
                                    </template>
                                    Añadir
                                </Button>
                            </Space>
                        </template>
                    </Select> -->
                    <!-- cuando tienes sub niveles -->
                    <TreeSelect
                        v-model:value="form.category_id"
                        show-search
                        style="width: 100%"
                        :dropdown-style="{ maxHeight: '400px', overflow: 'auto' }"
                        placeholder="Seleccionar Categoría"
                        allow-clear
                        :tree-data="categoriesData"
                        tree-node-filter-prop="label"
                        :height="233"
                    >
                        <template #title="{ value: val, label }">
                            <b v-if="val === 'parent 1-1'" style="color: #08c">sss</b>
                            <template v-else>{{ label }}</template>
                        </template>
                    </TreeSelect>
                    <InputError :message="form.errors.category_id" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="brand_id" value="Marca" />
                    <Select
                        id="brand_id"
                        v-model:value="form.brand_id"
                        placeholder="Seleccionar Marca"
                        style="width: 100%"
                        :options="brandsData"
                    >
                        <template #dropdownRender="{ menuNode: menu }">
                            <VNodes :vnodes="menu" />
                            <Divider style="margin: 4px 0" />
                            <Space style="padding: 4px 8px">
                                <Input ref="inputRef" v-model:value="formBrand.description" />
                                <Button type="text" @click="addBrand">
                                    <template #icon>
                                        <font-awesome-icon :icon="faPlus" class="mr-1" />
                                    </template>
                                    Añadir
                                </Button>
                            </Space>
                        </template>
                    </Select>
                    <InputError :message="form.errors.category_id" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="usine" value="Código Fabrica" />
                    <TextInput
                        id="usine"
                        v-model="form.usine"
                        type="text"
                        class="block w-full mt-1"
                        autofocus
                    />
                    <InputError :message="form.errors.usine" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="interne" value="Código Interno" />
                    <TextInput
                        id="interne"
                        v-model="form.interne"
                        type="text"
                        class="block w-full mt-1"
    
                    />
                    <InputError :message="form.errors.interne" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="description" value="Descripción" />
                    <textarea
                        id="description"
                        v-model="form.description"
                        type="text"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <div>
                        <InputLabel for="purchase_prices" value="Precio de compra" />
                        <TextInput
                            id="purchase_prices"
                            v-model="form.purchase_prices"
                            type="text"
                            class="block w-full mt-1"

                        />
                        <InputError :message="form.errors.purchase_prices" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                        <div>
                            <InputLabel for="sale_prices" value="Precio de venta" />
                            <TextInput
                                id="sale_prices"
                                v-model="form.sale_prices.high"
                                type="text"
                                class="block w-full mt-1"

                            />
                            <InputError :message="form.errors[`sale_prices.high`]" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="sale_prices_medium" value="Precio de venta Medio" />
                            <TextInput
                                id="sale_prices_medium"
                                v-model="form.sale_prices.medium"
                                type="text"
                                class="block w-full mt-1"

                            />
                            <InputError :message="form.errors[`sale_prices.medium`]" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="sale_prices_under" value="Precio de venta Minimo" />
                            <TextInput
                                id="sale_prices_under"
                                v-model="form.sale_prices.under"
                                type="text"
                                class="block w-full mt-1"

                            />
                            <InputError :message="form.errors[`sale_prices.under`]" class="mt-2" />
                        </div>
                    </div>
                    <div v-if="form.presentations" class="mt-4">
                        <label>
                            Presentaciones
                        </label>
                        <div  class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800">Descripción</th>
                                        <th class="px-6 py-3">Cantidad</th>
                                    </tr>
                                </thead>
                                <tr v-for="(item, index) in form.sizes" v-bind:key="index" class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        {{ item.size }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.quantity }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="image" value="Imagen" />
                    <div class="flex justify-center space-x-2">
                        <figure class="max-w-lg">
                            <img class="h-auto max-w-full rounded-lg" :src="form.image">
                            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen Actual</figcaption>
                        </figure>
                    </div>
                    <!-- <div class="mb-4">
                        <input type="file" @input="form.imageNew = $event.target.files[0]" />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div> -->
                    <ModalCropperImage @eventdataproduct="getDataProductImage" :product="props.product"></ModalCropperImage>
                </div>
            </ConfigProvider>
        </template>

        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar
                    </PrimaryButton>
                    <Link :href="route('products.index')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
