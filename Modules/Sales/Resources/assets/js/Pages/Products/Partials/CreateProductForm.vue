<script setup>
    import { useForm, Link } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { library } from "@fortawesome/fontawesome-svg-core";
    import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";
    import Keypad from '@/Components/Keypad.vue';
    import swal from 'sweetalert';
    import { watchEffect } from 'vue';

    const props = defineProps({
        establishments: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        usine: '',
        interne: '',
        description: '',
        image: '',
        purchase_prices: '',
        presentations: true,
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
        local_id: 1

    });

    const createProduct = () => {
        form.post(route('products.store'), {
            forceFormData: true,
            errorBag: 'createProduct',
            preserveScroll: true,
            onSuccess: () =>{ 
                form.reset()
                swal('Producto registrado con exito.')
            },
        });
    };

    const addSize = () => {
        let ar = {
            size:'',
            quantity: ''
        };
        form.sizes.push(ar);
    };

    const removeSize = (index) => {
        if(index>0){
            form.sizes.splice(index,1);
        }
    };

     const getDataProductImage = (data) => {
        form.pathImage = '/storage/' + data.path;
        form.image = data.path;
    }

    library.add(faTrashAlt);

    watchEffect(() => {
        if (form.presentations) {
            form.stock = null;
        }
    });



</script>

<template>
    <FormSection @submitted="createProduct" class="">
        <template #title>
            Producto Detalles
        </template>

        <template #description>
            Crear nuevo producto para realizar ventas
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-2 ">
                <InputLabel for="stablishment" value="Establecimiento" />
                <select v-model="form.local_id" id="stablishment" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <template v-for="(establishment, index) in props.establishments" :key="index">
                        <option :value="establishment.id">{{ establishment.description }}</option>
                    </template>
                </select>
                <InputError :message="form.errors.local_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
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
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="interne" value="Código Interno" />
                <TextInput
                    id="interne"
                    v-model="form.interne"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.interne" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="description" value="Descripción" />
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="image" value="Imagen" />
                <!-- <div class="flex justify-center space-x-2">
                    <figure class="max-w-lg">
                        <img class="h-auto max-w-full rounded-lg" :src="form.pathImage">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen</figcaption>
                    </figure>
                </div>
                <ModalCropperImage @eventdataproduct="getDataProductImage"></ModalCropperImage> -->
                <input type="file" @input="form.image = $event.target.files[0]" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="purchase_prices" value="Precio de compra" />
                <TextInput
                    id="purchase_prices"
                    v-model="form.purchase_prices"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.purchase_prices" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="sale_prices" value="Precio de venta" />
                <TextInput
                    id="sale_prices_high"
                    v-model="form.sale_prices.high"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors[`sale_prices.high`]" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="sale_prices_medium" value="Precio de venta Medio" />
                <TextInput
                    id="sale_prices_medium"
                    v-model="form.sale_prices.medium"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors[`sale_prices.medium`]" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="sale_prices_under" value="Precio de venta Minimo" />
                <TextInput
                    id="sale_prices_under"
                    v-model="form.sale_prices.under"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors[`sale_prices.under`]" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="flex items-center">
                    <input v-model="form.presentations" id="checked-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">¿Tiene diferentes tallas?</label>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="sale_prices_under" value="Stock" />
                <TextInput
                    id="sale_prices_under"
                    v-model="form.stock"
                    type="number"
                    class="block w-full mt-1"
                    :class="form.presentations ? 'bg-gray-500' : ''"
                    :readonly="form.presentations"
                />
                <InputError :message="form.errors.stock" class="mt-2" />
            </div>
            <div v-show="form.presentations" class="col-span-6 sm:col-span-6">
                <label>
                    Tallas
                    <button @click="addSize" type="button" class="inline-block px-6 py-2.5 bg-transparent text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:text-blue-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring-0 active:bg-gray-200 transition duration-150 ease-in-out">Agregar</button>
                </label>
                <div v-for="(item, index) in form.sizes" v-bind:key="index">
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
                                    <InputError :message="form.errors[`sizes.${index}.size`]" class="mt-2" />
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
                                    <InputError :message="form.errors[`sizes.${index}.quantity`]" class="mt-2" />
                                </div>
                            </td>
                            <td style="padding: 4px;" valign="bottom">
                                <button @click="removeSize(index)" type="button" class="px-2 py-1 inline-block rounded-full bg-blue-600 text-white leading-normal uppercase shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                    <font-awesome-icon :icon="faTrashAlt" />
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </template>

        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                    <Link :href="route('products.index')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
