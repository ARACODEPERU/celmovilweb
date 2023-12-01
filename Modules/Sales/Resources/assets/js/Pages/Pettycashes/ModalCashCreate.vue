<script setup>
    import DialogModal from '@/Components/DialogModal.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import InputError from '@/Components/InputError.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const form = useForm({
        local_id: '',
        starting_amount: '',
        seller_name: ''
    });
    const displayModal = ref(false);
    const openModalCashCreate = () => {
        displayModal.value = true;
    };
    const closeModal = () => {
        form.reset();
        displayModal.value = false;
    };

    const props = defineProps({
        locals: {
            type: Object,
            default: () => ({}),
        }
    });

    const createCash = () => {
        form.post(route('pettycash.store'), {
            forceFormData: true,
            errorBag: 'createCash',
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    };
</script>

<template>
    <button @click="openModalCashCreate" type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Nuevo</button>
    <DialogModal :show="displayModal" @close="closeModal">
        <template #title>
            Abrir Caja Chica
        </template>
        <template #content>

            <form>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <InputLabel value="Local" class="mb-1" />
                        <select class="form-select appearance-none
                            block
                            w-full
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding bg-no-repeat
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            v-model="form.local_id"
                            >
                                <option selected>Seleccionar</option>
                                <template v-for="(local, index) in props.locals">
                                    <option :value="local.id">{{ local.description }}</option>
                                </template>
                          </select>
                        <InputError :message="form.errors.local_id" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <InputLabel value="Monto de Inicio" />
                        <TextInput
                            v-model="form.starting_amount"
                            type="text"
                            class="block w-full mt-1"
                            autofocus
                        />
                        <InputError :message="form.errors.starting_amount" class="mt-2" />
                    </div>
                    <div class="form-group mb-6">
                        <InputLabel value="Nombre Vendedor" />
                        <TextInput
                            v-model="form.seller_name"
                            type="text"
                            class="block w-full mt-1"
                        />
                        <InputError :message="form.errors.seller_name" class="mt-2" />
                    </div>
                </div>
           </form>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="createCash"
            >
                Guardar
            </DangerButton>
        </template>
    </DialogModal>
</template>
