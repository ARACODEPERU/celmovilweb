<script setup>
    import { useForm } from '@inertiajs/vue3';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import swal from 'sweetalert';
    import Keypad from '@/Components/Keypad.vue';
    import { ref } from 'vue';

    const props = defineProps({
        company: {
            type: Object,
            default: () => ({}),
        },
        ubigeo: {
            type: Object,
            default: () => ({})
        },
    });

    const form = useForm({
        ruc: props.company.ruc,
        name: props.company.name,
        business_name: props.company.business_name,
        tradename: props.company.tradename,
        fiscal_address: props.company.fiscal_address,
        phone: props.company.phone,
        representative: props.company.representative,
        email: props.company.email,
        logo: null,
        logo_old: props.company.logo,
        logo_document_old: props.company.logo_document,
        logo_document: null,
        key_sunat: props.company.key_sunat,
        user_sunat: props.company.user_sunat ? props.company.user_sunat : null,
        certificate_sunat: props.company.certificate_sunat,
        mode: props.company.mode,
        ubigeo: props.company.ubigeo,
        ubigeo_description: null
    });

    if(form.ubigeo){
        const ubigeo = props.ubigeo.find(row => row.district_id.toLowerCase() === form.ubigeo.toLowerCase());
        form.ubigeo_description = ubigeo ? ubigeo.department_name+'-'+ubigeo.province_name+'-'+ubigeo.district_name : '';
    }


    const createOrUpdateCompany = () => {
        form.post(route('company_update_create'), {
            errorBag: 'createOrUpdateCompany',
            preserveScroll: true,
            onSuccess: () => {
                swal('Datos registrados con éxito');
            }
        });
    };

    const searchUbigeos = ref([]); // Inicializa searchUbigeos como una matriz vacía en lugar de null

    const filterCities = () => {
        if (form.ubigeo_description.trim() === '') {
            searchUbigeos.value = [];
            return;
        }

        searchUbigeos.value = props.ubigeo.filter(row =>
            row.district_name.toLowerCase().includes(form.ubigeo_description.toLowerCase())
        );
    }
    const selectCity = (item) => {
        form.ubigeo_description = item.department_name+'-'+item.province_name+'-'+item.district_name;
        form.ubigeo = item.district_id;
        searchUbigeos.value = []; // Limpiar la lista de búsqueda después de seleccionar una ciudad
    }
 </script>

<template>
    <FormSection @submitted="createOrUpdateCompany">
        <template #title>
            Información de la empresa 
        </template>

        <template #description>
            Detalles
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="ruc" value="Ruc*" />
                <TextInput
                    id="ruc"
                    v-model="form.ruc"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.ruc" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="name" value="Nombre*" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="business_name" value="Nombre del Negocio*" />
                <TextInput
                    id="business_name"
                    v-model="form.business_name"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.business_name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="tradename" value="Nombre comercial*" />
                <TextInput
                    id="tradename"
                    v-model="form.tradename"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.tradename" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="fiscal_address" value="Dirección fiscal*" />
                <TextInput
                    id="fiscal_address"
                    v-model="form.fiscal_address"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.fiscal_address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="email" value="Email*" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="block w-full mt-1"
                    
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6 ">
                <InputLabel for="address" value="Ciudad" />
                <div class="relative">
                    <TextInput 
                    v-model="form.ubigeo_description" 
                    @input="filterCities"
                    placeholder="Buscar Distrito"
                    type="text" 
                    class="block w-full mt-1" />
                    <ul v-if="searchUbigeos && searchUbigeos.length > 0" class="list-disc list-inside absolute z-50 w-full bg-white border border-gray-300 rounded-md mt-1">
                        <li v-for="item in searchUbigeos" :key="item.id" class="px-4 cursor-pointer hover:bg-gray-100" @click="selectCity(item)">
                            {{ item.department_name+'-'+item.province_name+'-'+item.district_name }}
                        </li>
                    </ul>
                </div>
                
                <div>
                    <InputError :message="form.errors.ubigeo" class="mt-2" />
                </div>
            </div>
            
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="representative" value="Representante" />
                <TextInput
                    id="representative"
                    v-model="form.representative"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.representative" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="phone" value="Teléfono*" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <figure v-if="form.logo_old" class="max-w-lg">
                    <img class="h-auto max-w-full rounded-lg" :src="'/storage/'+form.logo_old" alt="image description">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Logo Actual</figcaption>
                </figure>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="small_size">Logo - recomienda 200x200*</label>
                <input type="file" @input="form.logo = $event.target.files[0]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="logo_small_size" >
                <InputError :message="form.errors.logo" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <figure v-if="form.logo_document_old" class="max-w-lg">
                    <img class="h-auto max-w-full rounded-lg" :src="'/storage/'+form.logo_document_old" alt="image description">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Logo Actual</figcaption>
                </figure>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="small_size">Logo - se recomienda 317x48</label>
                <input type="file" @input="form.logo_document = $event.target.files[0]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="document_small_size" >
            </div>

            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="user_sunat" value="Usuario Sunat" />
                <TextInput
                    id="user_sunat"
                    v-model="form.user_sunat"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.user_sunat" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="key_sunat" value="Clave Sunat" />
                <TextInput
                    id="key_sunat"
                    v-model="form.key_sunat"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.key_sunat" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="small_size">Certificado Sunat</label>
                <input  @input="form.certificate_sunat = $event.target.files[0]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="small_size" type="file">
            </div>
            <div class="col-span-6">
                <div class="flex flex-wrap">
                    <div class="flex items-center mr-4">
                        <input v-model="form.mode" :value="'prod'" id="red-radio" type="radio" name="colored-radio" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="red-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Producción</label>
                    </div>
                    <div class="flex items-center mr-4">
                        <input v-model="form.mode" :value="'demo'" id="purple-radio" type="radio" name="colored-radio" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="purple-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Demo</label>
                    </div>
                </div>
                <InputError :message="form.errors.mode" class="mt-2" />
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
                        Guardar
                    </PrimaryButton>
                </template>
            </Keypad>
        </template>
    </FormSection>
</template>
