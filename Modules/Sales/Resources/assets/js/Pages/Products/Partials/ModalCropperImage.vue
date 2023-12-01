<script setup>
    import 'cropperjs/dist/cropper.css';
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import DangerButton from '@/Components/DangerButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import swal from 'sweetalert';
    import CropperImage from '@/Components/CropperImage.vue';

    const props = defineProps({
        product: {
            type: Object,
            default: () => ({}),
        }
    });

    const form = useForm({
        image: null,
        product_id: props.product.id
    });


    const isModalOpen = ref(false)

    const openModal = () => {
        isModalOpen.value = true

    }

    const closeModal = () => {
        isModalOpen.value = false
    }

    const cropImageAndSave = (res) => {
        form.image = res;
    }

    const emit = defineEmits(['eventdataproduct']);

    const cropImage = () => {
        axios.post(route('product_upload_image'), form ).then((res) => {
            emit('eventdataproduct',res.data);
            swal('Imagen Modificada con exito');
            closeModal();
        });
        //this.$refs.cropper.resetCropper();
    }
</script>

<template>
    <div class="flex justify-center space-x-2">
        <button
            @click="openModal()"
            type="button"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
            Cambiar Imagen
        </button>
    </div>
    <div>
        <!-- modal -->
        <div class="fixed z-9999 inset-0 overflow-y-auto" :class="{ 'hidden': !isModalOpen }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="closeModal">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
        
                <!-- Contenido del modal aquí -->
                <div class="inline-block align-bottom bg-white rounded-lg  text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="text-lg px-6 py-4">
                        Imagen
                    </div>
                    <div class="px-4 py-3 sm:px-6" style="max-height: 450px; overflow-y: auto;overflow-x: hidden;">
                        <CropperImage
                            ref="cropper"
                            @onCrop="cropImageAndSave"
                        ></CropperImage>
                    </div>
                    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">

                        <DangerButton
                            class="mr-3"
                            @click="cropImage()"
                        >
                            Guardar
                        </DangerButton>
                        <SecondaryButton @click="closeModal()">
                            Cancel
                        </SecondaryButton>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>