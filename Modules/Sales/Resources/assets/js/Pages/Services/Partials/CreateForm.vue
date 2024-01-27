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
        }
    });

    const form = useForm({
        usine: '',
        interne: '',
        description: '',
        sale_prices:{
            high:'',
            medium: '',
            under:''
        },
        local_id: 1
    });

    const createService = () => {
        form.post(route('store_service'), {
            forceFormData: true,
            errorBag: 'createService',
            preserveScroll: true,
            onSuccess: () =>{ 
                form.reset()
                swal('Producto registrado con exito.')
            },
        });
    };

</script>

<template>
    <FormSection @submitted="createService" class="">
        <template #title>
            Producto Detalles
        </template>
        <template #description>
            Crear nuevo producto para realizar ventas
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
        </template>
        <template #actions>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                    <Link :href="route('sales_services')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
