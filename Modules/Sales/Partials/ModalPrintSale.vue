<script setup>
    import Modal from '@/Components/Modal.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    const emit = defineEmits(['close']);

    defineProps({
        show: {
            type: Boolean,
            default: false,
        },
        maxWidth: {
            type: String,
            default: '2xl',
        },
        closeable: {
            type: Boolean,
            default: true,
        },
    });

    const close = () => {
        emit('close');
    };
    
</script>
<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="px-6 py-4">
            <div class="text-lg">
                Imprimir Ticket
            </div>

            <div class="mt-4">

            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
            <SecondaryButton @click="close">
                Cancel
            </SecondaryButton>
        </div>
    </Modal>
</template>

