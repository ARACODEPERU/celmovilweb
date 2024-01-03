<script setup>
import { useForm, Link } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import 'cropperjs/dist/cropper.css';
import CropperImage from '@/Components/CropperImage.vue';
import Swal2 from 'sweetalert2';
import { ref, watch } from 'vue';
import { 
    ConfigProvider, 
    Select,
    DatePicker, 
    Input
 } from 'ant-design-vue';

import esES from 'ant-design-vue/es/locale/es_ES';
import { FileInput } from 'flowbite-vue'

const props = defineProps({
    identityDocumentTypes: {
        type: Object,
        default: () => ({}),
    },
    ubigeo: {
        type: Object,
        default: () => ({})
    },
    person: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    id: props.person.id,
    student_id: props.person.student_id,
    document_type_id: props.person.document_type_id,
    number: props.person.number,
    telephone: props.person.telephone,
    email: props.person.email,
    image: props.person.image,
    image_preview: props.person.image_preview,
    address: props.person.address,
    ubigeo: props.person.ubigeo,
    birthdate: props.person.birthdate,
    names: props.person.names,
    father_lastname: props.person.father_lastname,
    mother_lastname: props.person.mother_lastname,
    ubigeo_description: props.person.city ?? null
});

const updateInfoPerson = () => {

    form.post(route('user-update-profile-store'), {
        forceFormData: true,
        errorBag: 'updateInfoPerson',
        preserveScroll: true,
        onSuccess: () => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se registró correctamente',
                icon: 'success',
            });
        },
    });
}

const filterOption = (input, option) => {
    const inputValueLower = input.toLowerCase();
    const optionTitleLower = option.label.toLowerCase();
    return optionTitleLower.includes(inputValueLower);
};

const cropImageAndSave = (res) => {
    form.image = res;
}
</script>

<template>
    <ConfigProvider :locale="esES">
        <div class="px-4 py-5 bg-white sm:p-6 shadow dark:bg-gray-800 sm:rounded-tl-md sm:rounded-tr-md">
            <div class="grid grid-cols-6 gap-6 ">
                <div class="col-span-6 sm:col-span-4">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-2 ">
                            <InputLabel for="document_type_id" value="Tipo *" />
                            <Select v-model:value="form.document_type_id" style="width: 100%" :options="identityDocumentTypes.map((obj) => ({ value: obj.id, label: obj.description }))"></Select>
                            <InputError :message="form.errors.document_type_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-2 ">
                            <InputLabel for="number" value="Número *" />
                            <Input
                                id="number"
                                v-model:value="form.number"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.number" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-2 ">
                            <InputLabel for="birthdate" value="Fecha de nacimiento *" />
                            <Input v-model:value="form.birthdate" class="w-full" type="date" />
                            <InputError :message="form.errors.birthdate" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3 ">
                            <InputLabel for="ubigeo" value="Ciudad *" />
                            <Select
                                v-model:value="form.ubigeo"
                                show-search
                                placeholder="Seleccione una ciudad"
                                style="width: 100%"
                                :options="ubigeo.map((row) => ({value: row.district_id, label: row.department_name+'-'+row.province_name+'-'+row.district_name,district_name: row.district_name }))"
                                :filter-option="filterOption"
                            ></Select>
                            <InputError :message="form.errors.ubigeo" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <InputLabel for="address" value="Dirección *" />
                            <Input
                                id="address"
                                v-model:value="form.address"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.address" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3 ">
                            <InputLabel for="names" value="Nombres *" />
                            <Input
                                id="names"
                                v-model:value="form.names"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.names" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3 ">
                            <InputLabel for="father_lastname" value="Apellido Paterno *" />
                            <Input
                                id="father_lastname"
                                v-model:value="form.father_lastname"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.father_lastname" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3 ">
                            <InputLabel for="mother_lastname" value="Apellido Materno *" />
                            <Input
                                id="mother_lastname"
                                v-model:value="form.mother_lastname"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.mother_lastname" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3 ">
                            <InputLabel for="telephone" value="Teléfono *" />
                            <Input
                                id="telephone"
                                v-model:value="form.telephone"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.telephone" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <InputLabel for="email" value="Email *" />
                            <Input
                                id="email"
                                v-model:value="form.email"
                                type="text"
                                class="block w-full mt-1"
                                
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2 ">

                    <CropperImage
                        ref="cropper"
                        @onCrop="cropImageAndSave"
                    ></CropperImage>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md dark:bg-gray-700">
            <PrimaryButton @click="updateInfoPerson" type="buttom" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                </svg>
                Guardar
            </PrimaryButton>
        </div>
    </ConfigProvider>
</template>