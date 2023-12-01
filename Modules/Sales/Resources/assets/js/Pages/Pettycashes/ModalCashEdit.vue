<script setup>
    import DialogModal from '@/Components/DialogModal.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import InputError from '@/Components/InputError.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref, watch } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const form = useForm({
        local_id: '',
        starting_amount: '',
        seller_name: ''
    });

    const displayModalEdit = ref(false);

    const closeModalEdit = () => {
        displayModalEdit.value = false;
    };

    const props = defineProps({
        pettycash: {
            type: Object,
            default: () => ({})
        },
        locals: {
            type: Object,
            default: () => ({}),
        }
    });

    const editCash = () => {
        form.put(route('pettycash.update',form.id), {
            errorBag: 'editCash',
            preserveScroll: true,
            onSuccess: () => closeModalEdit(),
        });
    };

    watch(() => props.pettycash, (newValues) => {
        
        form.id = newValues.id
        form.local_id = newValues.local_sale_id
        form.starting_amount = newValues.beginning_balance
        form.seller_name = newValues.seller_name
        displayModalEdit.value = true;
    });

</script>

<template>
    
    <DialogModal :show="displayModalEdit" @close="closeModalEdit">
        <template #title>
            Editar Caja Chica
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
            <SecondaryButton @click="closeModalEdit">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="editCash"
            >
                Guardar
            </DangerButton>
        </template>
    </DialogModal>
</template>
