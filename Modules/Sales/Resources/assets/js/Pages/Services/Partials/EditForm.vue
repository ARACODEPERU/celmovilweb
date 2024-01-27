<script setup>
    import { useForm, Link } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Keypad from '@/Components/Keypad.vue';
    import swal from 'sweetalert';

    const props = defineProps({
        establishments: {
            type: Object,
            default: () => ({}),
        },
        product: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        usine: props.product.usine,
        interne: props.product.interne,
        description: props.product.description,
        sale_prices:JSON.parse(props.product.sale_prices),
        status: props.product.status == 1 ? true : false,
        local_id: props.product.local_id
    });

    const updateService = () => {
        form.put(route('update_service',props.product.id), {
            errorBag: 'updateService',
            preserveScroll: true,
            onSuccess: () =>{ 
                swal('Producto Actualizo con exito.')
            },
        });
    };

</script>

<template>
    <FormSection @submitted="updateService" class="">
        <template #title>
            Servicio Detalles
        </template>

        <template #description>
            Crear editar servicio para realizar ventas
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="usine" value="Código SUNAT" />
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
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="description" value="Descripción" />
                <textarea
                    id="description"
                    v-model="form.description"
                    rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                ></textarea>
                <InputError :message="form.errors.description" class="mt-2" />
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
                <InputLabel value="Estado" />
                <div class="flex items-center">
                    <input v-model="form.status" id="link-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="link-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Activo</label>
                </div>
            </div>
        </template>
        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Actualizar
                    </PrimaryButton>
                    <Link :href="route('sales_services')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
