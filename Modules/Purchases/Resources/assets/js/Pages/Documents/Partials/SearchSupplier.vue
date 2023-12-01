<script setup>
    import { useForm } from '@inertiajs/vue3';
    import ModalLarge from '@/Components/ModalLarge.vue';
    import { ref, watch } from 'vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import GreenButton from '@/Components/GreenButton.vue';
    import RedButton from '@/Components/RedButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { faShareFromSquare } from "@fortawesome/free-solid-svg-icons";
    import Swal2 from 'sweetalert2';

    const props = defineProps({
        documentTypes: {
            type: Object,
            default: () => ({})
        },
        display:{
            type: Boolean,
            default: () => ({})
        },
        closeModalSupplier: {
            type: Function,
            default: () => ({})
        },
        saleDocumentTypes: {
            type: null,
            default: () => ({})
        },
        ubigeo: {
            type: Object,
            default: () => ({})
        },
    })

    const form = useForm({
        id: '',
        document_type: '',
        number: '',
        telephone: '',
        full_name: '',
        email: '',
        address: '',
        ubigeo: '',
        ubigeo_description: '',
        presentations: false,
        is_provider: true
    });
    
    const disabledBtnSelect = ref(true);
    const person = ref({});

    const modalNewSearchClient = () => {
        axios.post(route('search_person_number'), form).then((res) => {
            if (res.data.status) {
                form.id = res.data.person.id;
                form.telephone = res.data.person.telephone;
                form.full_name = res.data.person.full_name;
                form.email = res.data.person.email;
                form.address = res.data.person.address;
                form.ubigeo_description = res.data.person.city
                form.ubigeo = res.data.person.ubigeo
                disabledBtnSelect.value = false;
                person.value = res.data.person;
            } else {
                form.errors.document_type = res.data.document_type;
                form.errors.number = res.data.number;
                Swal2.fire('Información Importante',res.data.alert,'info');
                disabledBtnSelect.value = true;
            }

        });
    }

    const emit = defineEmits(['supplierId']);
    
    const saveNewSearchClient = () => {
        axios.post(route('save_person_update_create'), form).then((res) => {
            disabledBtnSelect.value = false;
            Swal2.fire('Enhorabuena','Se registró correctamente','success');
            person.value = res.data;
        }).catch(error => {
            let validationErrors = error.response.data.errors;
            if (validationErrors && validationErrors.number) {
                const numberErrors = validationErrors.number;

                for (let i = 0; i < numberErrors.length; i++) {
                    form.setError('number', numberErrors[i]);
                }
            }
            if (validationErrors && validationErrors.full_name) {
                const fullNameErrors = validationErrors.full_name;

                for (let i = 0; i < fullNameErrors.length; i++) {
                    form.setError('full_name', fullNameErrors[i]);
                }
            }
            if (validationErrors && validationErrors.document_type) {
                const document_typeErrors = validationErrors.document_type;

                for (let i = 0; i < document_typeErrors.length; i++) {
                    form.setError('document_type', document_typeErrors[i]);
                }
            }
            if (validationErrors && validationErrors.ubigeo) {
                const ubigeoErrors = validationErrors.ubigeo;

                for (let i = 0; i < ubigeoErrors.length; i++) {
                    form.setError('ubigeo', ubigeoErrors[i]);
                }
            }
            if (validationErrors && validationErrors.email) {
                const emailErrors = validationErrors.email;

                for (let i = 0; i < emailErrors.length; i++) {
                    form.setError('email', emailErrors[i]);
                }
            }
            form.processing = false;
        });
    }

    watch(() => props.saleDocumentTypes, (id) => {
        if(id == 1){
            form.document_type = 6
        }else{
            form.document_type = 1
        }
        disabledBtnSelect.value = true;
    });

    const selectPersonNew = () => {
        emit('supplierId', person.value);
        form.reset();
    }

    const displayResultUbigeo = ref(false);
    
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
    <div>
        <ModalLarge :show="display" :onClose="closeModalSupplier" :icon="'/img/fabrica.png'">
            <template #title>
                Proveedor
            </template>
            <template #message>
                Registrar nuevo o editar buscando por su numero de documento
            </template>
            <template #content>
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel value="Tipo de Documento" class="mb-1" />
                        <select :disabled="saleDocumentTypes==1 ? true : false" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="form.document_type">
                            <option value="">Seleccionar</option>
                            <template v-for="(documentType, index) in documentTypes">
                                <option :value="documentType.id">{{ documentType.description }}</option>
                            </template>
                        </select>
                        <InputError :message="form.errors.document_type" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="number" value="Número de Doc." />
                        <TextInput id="number" v-model="form.number" type="number" class="block w-full mt-1"
                            autofocus />
                        <InputError :message="form.errors.number" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel v-if="form.document_type == 6" for="full_name" value="Razón Social" />
                        <InputLabel v-else for="full_name" value="Nombres" />
                        <TextInput id="full_name" v-model="form.full_name" type="text" class="block w-full mt-1"
                             />
                        <InputError :message="form.errors.full_name" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="telephone" value="Teléfono" />
                        <TextInput id="telephone" v-model="form.telephone" type="text" class="block w-full mt-1"
                             />
                        <InputError :message="form.errors.telephone" class="mt-2" />
                    </div>
                    
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" autofocus />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="address" value="Dirección" />
                        <TextInput id="address" v-model="form.address" type="text" class="block w-full mt-1" />
                        <InputError :message="form.errors.address" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-3">
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
                </div>
            </template>
            <template #buttons>
                <RedButton @click="modalNewSearchClient()" class="mr-2">Buscar</RedButton>
                <PrimaryButton @click="saveNewSearchClient()" class="mr-2">
                    Guardar
                </PrimaryButton>
                <GreenButton 
                    class="mr-2"
                    :disabled="disabledBtnSelect"
                    @click="selectPersonNew"
                >
                    <font-awesome-icon :icon="faShareFromSquare" />
                    Seleccionar
                </GreenButton>
            </template>
        </ModalLarge>
    </div>
</template>
