<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Keypad from '@/Components/Keypad.vue';
import Swal2 from 'sweetalert2';
import { ref, watch } from 'vue';
import { Select, Input, Textarea } from 'flowbite-vue'
import Editor from '@tinymce/tinymce-vue'
import ImageCompressorjs from '@/Components/ImageCompressorjs.vue';

const props = defineProps({
    venture: {
        type: String,
        default: () => ({}),
    },
    items: {
        type: Object,
        default: () => ({}),
    },
    tiny_api_key: {
        type: String,
        default: () => ({}),
    }
});


const form = useForm({
    item_id: null,
    title: null,
    description: null,
    image: null,
    image_pre: null,
    video: null,
    status: true
});

const createTestimony = () => {
    
    try {
        form.post(route('cms_testimonies_store'), {
            forceFormData: true,
            errorBag: 'createTestimony',
            preserveScroll: true,
            onSuccess: () => {
                Swal2.fire({
                    title: 'Enhorabuena',
                    text: 'Se registró correctamente',
                    icon: 'success',
                });
                form.reset()
            },
        });
    throw new Error('Este es un error de ejemplo');
    } catch (error) {
    // Manejar la excepción
        console.error('Se produjo un error:', error.message);
    } finally {
    // Este bloque opcional se ejecuta siempre, haya o no haya excepción
        console.log('Este bloque siempre se ejecuta');
    }
}



const handleImageCompressed = (file) => {
    form.image = file;
    form.image_pre = file;
};


</script>

<template>
    <FormSection @submitted="createTestimony" class="">
        <template #title>
            Testimonio Detalles
        </template>

        <template #description>
            Crear nuevo Testimonio, Los campos con * son obligatorios
        </template>

        <template #form>
            <div class="col-span-6">
                <Select
                    v-model="form.item_id"
                    :options="items"
                    label="Producto o Servicio *"
                    placeholder="Seleccionar"
                    class="w-full"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="col-span-6">
                <Input
                    v-model="form.title"
                    label="Título *"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="col-span-6">
                <InputLabel for="description" value="Descripción *" />
                <Editor
                    id="description"
                    :api-key="tiny_api_key"
                    v-model="form.description"
                    :init="{
                        plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
                        language: 'es',
                    }"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="col-span-6">
                <InputLabel for="content" value="Imagen *" />
                <div class="flex justify-center space-x-2">
                    <figure class="max-w-lg">
                        <img class="h-auto max-w-full rounded-lg" :src="form.image_pre">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen Actual</figcaption>
                    </figure>
                </div>
                <!-- <input @input="form.image = $event.target.files[0]" accept=".svg, .png, .jpg, .jpeg, .gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file"> -->
                <ImageCompressorjs :onImageCompressed="handleImageCompressed" /> 
                <InputError :message="form.errors.image" class="mt-2" />
            </div>
            <div class="col-span-6">
                <Textarea
                    v-model="form.video"
                    :rows="4"
                    label="Iframe del vídeo *"
                    placeholder="Código del vídeo... por favor verifique que el código no contenga emoticonos(genera error). Borre los emoticonos manualmente"
                />
                <InputError :message="form.errors.video" class="mt-2" />
                <div class="mt-4 w-full" v-html="form.video"></div>
            </div>
        </template>

        <template #actions>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="mr-1">
                {{ form.progress.percentage }}%
            </progress>
            <Keypad>
                <template #botones>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        Guardar
                    </PrimaryButton>
                    <Link :href="route('cms_testimonies_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>