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
    import ModalCropperImage from './ModalCropperImage.vue';
    import swal from 'sweetalert';

    const props = defineProps({
        product: {
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
                    id="sale_prices"
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
            <div class="col-span-6 sm:col-span-6">
                <label>
                    Tallas
                </label>
                <div  class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800">Talla</th>
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
