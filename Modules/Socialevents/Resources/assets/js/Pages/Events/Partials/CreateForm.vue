<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Keypad from '@/Components/Keypad.vue';
import Swal2 from 'sweetalert2';
import { ref, watch, onMounted } from 'vue';
import Editor from '@tinymce/tinymce-vue'
import { 
    ConfigProvider,
    Select, 
    InputNumber,
    Textarea,
    RangePicker,
    Switch, 
    Input, 
    Upload,
    Flex
} from 'ant-design-vue';
import esES from 'ant-design-vue/es/locale/es_ES';

import 'cropperjs/dist/cropper.css';
import CropperImage from '@/Components/CropperImage.vue';
import { Radio } from 'flowbite-vue'

const props = defineProps({
    categories: {
        type: Object,
        default: () => ({}),
    },
    instructors: {
        type: Object,
        default: () => ({}),
    },
    locales: {
        type: Object,
        default: () => ({}),
    },
    tiny_api_key: {
        type: String,
        default: null,
    }
});

const form = useForm({
    category_id: null,
    title: null,
    description: null,
    iframe_transmission: null,
    image1: null,
    image2: null,
    image3: null,
    image4: null,
    advertising_video: null,
    date: null,
    tickets_quantity: null,
    broadcast: false,
    locales: [],
    exhibitors: [],
    just_transmit: 0
});

const createNow = () => {
    form.post(route('even_events_store'), {
        forceFormData: true,
        errorBag: 'createNow',
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
}

const cropImageAndSave = (res) => {
    form.image1 = res;
}

watch(() => form.just_transmit, (data) => {
    if(data == 0){
        form.broadcast = false
    }else{
        form.broadcast = true
    }
});
</script>

<template>
    <FormSection @submitted="createNow" class="">
        <template #title>
            Eventos Detalles
        </template>

        <template #description>
            Crear nuevo Eventos, Los campos con * son obligatorios
        </template>

        <template #form>
            <ConfigProvider :locale="esES">
                <div class="col-span-6">
                    <Flex :vertical="false">
                        <div style="width: 50%;" class="mr-1 flex items-center p-2 border border-gray-200 rounded dark:border-gray-700">
                            <Radio v-model="form.just_transmit" label="Evento Social" name="radio-bordered" value="0" />
                        </div>
                        <div style="width: 50%;" class="ml-1 flex items-center p-2 border border-gray-200 rounded dark:border-gray-700">
                            <Radio v-model="form.just_transmit" label="Sólo transmitir" name="radio-bordered" value="1" />
                        </div>
                    </Flex>
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6 sm:col-span-2">
                    <InputLabel for="category_id" value="Categoría *" class="mb-1" />
                    <Select 
                        style="width: 100%;"
                        v-model:value="form.category_id" 
                        id="category_id"
                        :options="categories.map((obj) => ({value:obj.id,label:obj.description}))"
                    />
                    <InputError :message="form.errors.category_id" class="mt-2" />
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6 sm:col-span-4">
                    <InputLabel for="dates" value="Fechas desde Hasta *" class="mb-1" />
                    <RangePicker id="dates" v-model:value="form.date" style="width: 100%;" :locale="esES" />
                    <InputError :message="form.errors.date" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="title" value="Nombre *" class="mb-1" />
                    <Textarea v-model:value="form.title" id="title" />
                    <InputError :message="form.errors.title" class="mt-2" />
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6">
                    <InputLabel for="description" value="Descripción *" class="mb-1" />
                    <Editor
                        :api-key="tiny_api_key"
                        v-model="form.description"
                        :init="{
                            plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
                            language: 'es',
                        }"
                    />
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6">
                    <InputLabel for="advertising_video" value="Spot publicitario*" class="mb-1" />
                    <Textarea
                        id="advertising_video"
                        v-model:value="form.advertising_video"
                    />
                    <InputError :message="form.errors.advertising_video" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="advertising_video" value="¿Se transmitirá en vivo por la página web?*" class="mb-1" />
                    <Switch v-model:checked="form.broadcast" class="bg-gray-200" />
                </div>
                <div v-if="form.broadcast" class="col-span-6">
                    <InputLabel for="iframe_transmission" value="Codigo de la Transmisión *" class="mb-1" />
                    <Textarea v-model:value="form.iframe_transmission" id="iframe_transmission" :rows="6" />
                    <InputError :message="form.errors.iframe_transmission" class="mt-2" />
                </div>

                
                <div v-if="form.just_transmit == 0" class="col-span-6">
                    <InputLabel for="file_input" value="Imagen *" />
                    <CropperImage
                        :aspectRatio="1920 / 500"
                        :viewMode="1"
                        ref="cropper"
                        @onCrop="cropImageAndSave"
                    ></CropperImage>
                    <InputError :message="form.errors.image1" class="mt-2" />
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6 sm:col-span-3">
                    <InputLabel for="exhibitors" value="Expositores *" class="mb-1" />
                    <Select
                        id="exhibitors"
                        v-model:value="form.exhibitors"
                        :options="instructors.map((obj) => ({value: obj.person.id,label:obj.person.full_name}))"
                        style="width: 100%;"
                        mode="multiple"
                    />
                    <InputError :message="form.errors.tickets_quantity" class="mt-2" />
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6 sm:col-span-3">
                    <InputLabel for="locales" value="Local *" class="mb-1" />
                    <Select
                        id="locales"
                        v-model:value="form.locales"
                        :options="locales.map((ob) => ({value: ob.id,label:ob.names}))"
                        style="width: 100%;"
                        mode="multiple"
                    />
                    <InputError :message="form.errors.tickets_quantity" class="mt-2" />
                </div>
                <div v-if="form.just_transmit == 0" class="col-span-6 sm:col-span-2">
                    <InputLabel for="tickets_quantity" value="Cantidad de Entradas *" class="mb-1" />
                    <InputNumber
                        id="tickets_quantity"
                        v-model:value="form.tickets_quantity"
                        style="width: 100%;"
                    />
                    <InputError :message="form.errors.tickets_quantity" class="mt-2" />
                </div>
            </ConfigProvider>
        </template>

        <template #actions>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="mr-2">
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
                    <Link :href="route('even_eventos_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>