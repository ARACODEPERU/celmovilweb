<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Keypad from '@/Components/Keypad.vue';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import Swal2 from "sweetalert2";
    import { Link, router, useForm } from '@inertiajs/vue3';
    import { faPencilAlt, faCheck, faTrashAlt } from "@fortawesome/free-solid-svg-icons";
    import { ref } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SecondaryButton  from '@/Components/SecondaryButton.vue';

    const props = defineProps({
        page: {
            type: Object,
            default: () => ({}),
        },
        sections: {
            type: Object,
            default: () => ({}),
        },
        xsections: {
            type: Object,
            default: () => ({}),
        },
    });

    const displaySections = ref(false);

    const destroySection = (id) => {
        Swal2.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, Eliminar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return axios.delete(route('cms_pages_section_items_delete', id)).then((res) => {
                    if (!res.data.success) {
                        Swal2.showValidationMessage(res.data.message)
                    }
                    return res
                });
            },
            allowOutsideClick: () => !Swal2.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal2.fire({
                    title: 'Enhorabuena',
                    text: 'Se Eliminó correctamente',
                    icon: 'success',
                });
                router.visit(route('cms_pages_section_list', props.page.id), { replace: true, method: 'get' });
            }
        });
    }
    
    const closeModalSections = () => {
        displaySections.value = false;
    }
    const openModalSections = () => {
        displaySections.value = true;
    }

    const sectionForm = useForm({
        page_id: props.page.id,
        section_id: null,
        description: null
    });
    const loadingBoton = ref(false);
    const addSection = () => {
        
        router.visit(route('cms_pages_section_add'), {
            method: 'post',
            data: sectionForm,
            replace: false,
            preserveState: true,
            preserveScroll: true,
            onStart: visit => {
                loadingBoton.value = true;
            },
            onError: errors => { 
                sectionForm.setError({
                    description: errors.description,
                    section_id: errors.section_id
                });
             },
             onSuccess: page => { 
                displaySections.value = false; 
            },
             onFinish: visit => {
                loadingBoton.value = false;
             },
        });
    }
    
    const itemsForm = useForm({
        items: []
    });

    const itemsImages = ref([]);

    const descriptionSection = ref(null);
    const activeButonGroup = ref(false);
    const idSection = ref(null);
    const idGroup = ref(null);
    const descriptionGroup = ref(null);
    const loadingBotonGroup = ref(false);

    const getSectionItems = (id, description) => {
        idSection.value = id;
        descriptionSection.value = description;
        const element = document.getElementById('link-section-'+id);
        // Obtén todas las etiquetas <a> que tienen las clases y son diferentes al elemento con el ID
        const todasLasEtiquetasA = document.querySelectorAll('a.bg-red-500.text-white:not(#link-section-' + id + ')');

        // Itera a través de las etiquetas <a> y elimina las clases
        todasLasEtiquetasA.forEach(etiquetaA => {
            etiquetaA.classList.remove('bg-red-500');
            etiquetaA.classList.remove('text-white');
        });
        
        element.classList.add('bg-red-500');
        element.classList.add('text-white');
        axios.get(route('cms_pages_section_items_data',id)).then((res) => {
            res.data.items.forEach((it, index) => {
                if (it.item.type_id == 5) {
                    activeButonGroup.value = true;
                    idGroup.value = it.item.id;
                } else {
                    activeButonGroup.value = false;
                }
            });

            itemsForm.items = res.data.items;

            itemsForm.items = itemsForm.items.map(obj => ({ ...obj, image_preview: (obj.item.type_id == 1 ? obj.item.content : null ) }));

        });

    }

    const saveChangesItems = () => {
        const formData = new FormData();
        itemsForm.items.forEach((it, index) => {
            if(it.item.type_id != '5' ){
                if (it.item.content instanceof File) {
                    formData.append(`items[${index}][is_file]`, 'yes');
                } else if (typeof it.item.content === 'string') {
                    formData.append(`items[${index}][is_file]`, 'no');
                }

                formData.append(`items[${index}][id]`, it.item.id);
                formData.append(`items[${index}][type_id]`, it.item.type_id);
                formData.append(`items[${index}][content]`, it.item.content);
            }
        });

        axios.post(route('cms_pages_section_items_save'), formData).then((res) => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se registró correctamente',
                icon: 'success',
            });
        });
    }

    const displayModalCreateGroup = ref(false);

    const openModalCreateGroup = () => {
        displayModalCreateGroup.value = true;
    }
    const closeModalCreateGroup = () => {
        displayModalCreateGroup.value = false;
    }

    const createGroupSection = () => {
        loadingBotonGroup.value = true;
        let data = {
            section_id: idSection.value,
            group_id: idGroup.value,
            group_description: descriptionGroup.value
        }

        axios.post(route('cms_pages_section_group_save'), data).then((res) => {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se registró correctamente',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    let xid = idSection.value;
                    let xde = descriptionSection.value;
                    getSectionItems(xid, xde);
                }
            });
            loadingBotonGroup.value = false;
            displayModalCreateGroup.value = false;
            
        });
    }

    const destroyGroup = (id) => {
    Swal2.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, Eliminar!',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return axios.delete(route('cms_section_group_items_destroy', id)).then((res) => {
                if (!res.data.success) {
                    Swal2.showValidationMessage(res.data.message)
                }
                return res
            });
        },
        allowOutsideClick: () => !Swal2.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal2.fire({
                title: 'Enhorabuena',
                text: 'Se Eliminó correctamente',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    let xid = idSection.value;
                    let xde = descriptionSection.value;
                    getSectionItems(xid, xde);
                }
            });
        }
    });
}

const saveChangesGroupItems = (key) => {
    const formData = new FormData();
    itemsForm.items.forEach((it, index) => {
        if(index == key){
            it.item.items.forEach((sit, co) => {
                if (sit.content instanceof File) {
                    formData.append(`items[${co}][is_file]`, 'yes');
                } else if (typeof sit.content === 'string') {
                    formData.append(`items[${co}][is_file]`, 'no');
                }

                formData.append(`items[${co}][id]`, sit.id);
                formData.append(`items[${co}][type_id]`, sit.type_id);
                formData.append(`items[${co}][content]`, sit.content);
            });
        }
    });

    axios.post(route('cms_pages_section_items_save'), formData).then((res) => {
        Swal2.fire({
            title: 'Enhorabuena',
            text: 'Se registró correctamente',
            icon: 'success',
        }).then((result) => {
            if (result.isConfirmed) {
                let xid = idSection.value;
                let xde = descriptionSection.value;
                getSectionItems(xid, xde);
            }
        });
    });
}

const updateImagePreview = (index,image) => {
        const photo = image;

        if (! photo) return;

        const reader = new FileReader();

        //console.log(itemsForm.items[index]);
        itemsForm.items[index].item.content = image;

        reader.onload = (e) => {
            itemsForm.items[index].image_preview = e.target.result;
        };
        
        reader.readAsDataURL(photo);
    };
</script>

<template>
    <AppLayout title="Resumen">
        <div class="max-w-screen-2xl  mx-auto p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <nav class="flex px-4 py-3 border border-stroke text-gray-700 mb-4 bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <Link :href="route('dashboard')" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Inicio
                        </Link>
                    </li>
                    <li>
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <!-- <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Productos</a> -->
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">CMS</span>
                        </div>
                    </li>
                    
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <Link :href="route('cms_pages_list')"><span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Paginas</span></Link>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-8   00 md:ml-2 dark:text-gray-400">{{ page.description }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Secciones</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-4 md:col-span-1 p-4">
                            <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                
                                <a v-can="'cms_pagina_seccion_items'" @click="openModalSections" href="#" aria-current="true" class="block w-full px-4 py-2 text-white bg-blue-700 border-b border-gray-200 rounded-t-lg cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                                    Secciones
                                </a>
                                
                                <template v-for="(section, ke) in xsections">
                                    <a @click="getSectionItems(section.id,section.page_sections_description)" :id="'link-section-'+section.id" href="#" class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                                        {{ section.description }}
                                    </a>
                                    <button type="button" @click="destroySection(section.page_sections_id)" v-can="'cms_pagina_seccion_items_delete'">
                                        Eliminar
                                    </button>
                                </template>
                            </div>
                        </div>
                        <div class="col-span-4 sm:col-span-3 p-4">
                            <form @submit.prevent="saveChangesItems" enctype="multipart/form-data">
                                <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ descriptionSection }}</p>
                                <template v-if="itemsForm.items.length > 0">
                                    <div v-for="(it, ky) in itemsForm.items" class="mb-4 p-2 border border-stroke dark:border-strokedark">
                                        <template v-if="it.item.type_id == 1">
                                            <InputLabel for="content" value="Imagen *" />
                                            <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                {{ it.item.description }}
                                            </p>
                                            <div class="flex justify-center space-x-2">
                                                <figure class="max-w-lg">
                                                    <img class="h-auto max-w-full rounded-lg" :src="it.image_preview">
                                                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen Actual</figcaption>
                                                </figure>
                                            </div>
                                            
                                            <input @input="updateImagePreview(ky,$event.target.files[0])" accept=".svg, .png, .jpg, .jpeg, .gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                                        </template>
                                        <template v-if="it.item.type_id == 2">
                                            <InputLabel for="content" value="URL del Video *" />
                                            <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                {{ it.item.description }}
                                            </p>
                                            <TextInput
                                                id="content"
                                                v-model="it.item.content"
                                                type="text"
                                                class="block w-full mt-1"
                                            />
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">AV1, VP9, MP4 (RECOMENDADO. 5-10 MB).</p>
                                        </template>
                                        <template v-if="it.item.type_id == 3">
                                            <InputLabel for="content" value="Archivo *" />
                                            <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                {{ it.item.description }}
                                            </p>
                                            <input @input="it.item.content = $event.target.files[0]" accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOC, PPT o PPTX, XLS o XLSX (RECOMENDADO. 5-10 MB).</p>
                                        </template>
                                        <template v-if="it.item.type_id == 4">
                                            <InputLabel for="content" value="Texto *" />
                                            <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                {{ it.item.description }}
                                            </p>
                                            <textarea v-model="it.item.content" id="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                        </template>
                                        
                                        <template v-if="it.item.type_id == 5">
                                           <div>
                                            <div class="flex justify-end px-4 pt-4">
                                                <button @click="saveChangesGroupItems(ky)" title="Guardar Cambios" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                    <font-awesome-icon :icon="faCheck" />
                                                </button>
                                                <button @click="destroyGroup(it.item.id)" title="Eliminar" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <font-awesome-icon :icon="faTrashAlt" />
                                                </button>
                                            </div>
                                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ it.item.description }}</h5>
                                            
                                            <template v-for="(itm, ky) in it.item.items">
                                                
                                                <template v-if="itm.type_id == 1">
                                                    <InputLabel for="content" value="Imagen *" />
                                                    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                        {{ itm.description }}
                                                    </p>
                                                    <div class="flex justify-center space-x-2">
                                                        <figure class="max-w-lg">
                                                            <img style="width: 200px;" class="h-auto rounded-lg" :src="itm.content">
                                                            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen Actual</figcaption>
                                                        </figure>
                                                    </div>
                                                    
                                                    <input @input="itm.content = $event.target.files[0]" accept=".svg, .png, .jpg, .jpeg, .gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                                                </template>
                                                <template v-if="itm.type_id == 2">
                                                    <InputLabel for="content" value="URL del Video *" />
                                                    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                        {{ itm.description }}
                                                    </p>
                                                    <TextInput
                                                        id="content"
                                                        v-model="itm.content"
                                                        type="text"
                                                        class="block w-full mt-1"
                                                    />
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">AV1, VP9, MP4 (RECOMENDADO. 5-10 MB).</p>
                                                </template>
                                                <template v-if="itm.type_id == 3">
                                                    <InputLabel for="content" value="Archivo *" />
                                                    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                        {{ itm.description }}
                                                    </p>
                                                    <input @input="itm.content = $event.target.files[0]" accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOC, PPT o PPTX, XLS o XLSX (RECOMENDADO. 5-10 MB).</p>
                                                </template>
                                                <template v-if="itm.type_id == 4">
                                                    <InputLabel for="content" value="Texto *" />
                                                    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                                                        {{ itm.description }}
                                                    </p>
                                                    <textarea v-model="itm.content" id="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                                </template>
                                            </template>
                                           </div> 
                                        </template>
                                        <!-- <InputError :message="form.errors.content" class="mt-2" /> -->
                                    </div>
                                    
                                </template>
                                <template v-else>
                                    <div class="flex border items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-medium">Esta seccion aun no tiene items</span> comuniquese con el administrador del sistema
                                        </div>
                                    </div>
                                </template>
                                <Keypad>
                                    <template #botones>
                                        <SecondaryButton @click="openModalCreateGroup()" :type="'button'" v-if="activeButonGroup" :class="{ 'opacity-25': itemsForm.processing }" :disabled="itemsForm.processing" class="mr-2">
                                            <svg v-show="itemsForm.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                            </svg>
                                            Crear {{ descriptionSection }}
                                        </SecondaryButton>
                                        <!-- !activeButonGroup -->
                                        <PrimaryButton v-if="itemsForm.items.length > 0" :class="{ 'opacity-25': itemsForm.processing }" :disabled="itemsForm.processing">
                                            <svg v-show="itemsForm.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                            </svg>
                                            Guardar
                                        </PrimaryButton>
                                        <Link :href="route('cms_pages_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                                    </template>
                                </Keypad>
                            </form>
                        </div>
                    </div>                     
                </div>
            </div>
        </div>
        <ModalSmall
            :show="displaySections"
            :onClose="closeModalSections"
        >
            <template #title>
                Secciones
            </template>
            <template #content>
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccione una opción</label>
                    <select v-model="sectionForm.section_id" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Seleccionar</option>
                        <option v-for="(row, con) in sections" :value="row.id">{{ row.description }}</option>
                    </select>
                    <InputError :message="sectionForm.errors.section_id" class="mt-2" />
                </div>
                <div class="mt-2">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                    <textarea v-model="sectionForm.description" id="message" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aquí..."></textarea>
                    <InputError :message="sectionForm.errors.description" class="mt-2" />
                </div>
            </template>
            <template #buttons>
               <PrimaryButton
                    :class="{ 'opacity-25': loadingBoton }" :disabled="loadingBoton"
                    @click="addSection()"
                    class="mr-2"
               >Agregar</PrimaryButton> 
            </template>
        </ModalSmall>
        <ModalSmall
            :show="displayModalCreateGroup"
            :onClose="closeModalCreateGroup"
        >
            <template #title>
                Crear {{ descriptionSection }}
            </template>
            <template #content>
                <div>
                    <label for="messageGroup" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                    <textarea required v-model="descriptionGroup" id="messageGroup" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aquí..."></textarea>
                </div>
            </template>
            <template #buttons>
               <PrimaryButton
                    :class="{ 'opacity-25': loadingBotonGroup }" :disabled="loadingBotonGroup"
                    @click="createGroupSection"
                    class="mr-2"
               >Guardar</PrimaryButton> 
            </template>
        </ModalSmall>
    </AppLayout>
</template>
