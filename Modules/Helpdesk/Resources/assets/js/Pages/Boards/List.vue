<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Swal2 from 'sweetalert2';
    import { faPlus, faCircleXmark } from "@fortawesome/free-solid-svg-icons";

    const displayModalPanel = ref(false);
    const btnMethod = ref(false);

    const props = defineProps({
        levels: {
            type: Object,
            default: () => ({}),
        },
        boards: {
            type: Object,
            default: () => ({}),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
    });

    const showModalPanel = () => {
        btnMethod.value = false;
        displayModalPanel.value = true;
        initializeDropdownItems();
    }

    const closeModalPanel = () => {
        displayModalPanel.value = false;
    }

    const form = useForm({
        id: null,
        description: null,
        image: null
    });
    
    const showModalEditPanel = (index) => {
        form.description = props.boards.data[index].description;
        form.id = props.boards.data[index].id;
        displayModalPanel.value = true;
        btnMethod.value = true;
        initializeDropdownItems();
    }

    const savePanel = () => {
        if(btnMethod.value == true){
            form.put(route('help-boards.update',form.id), {
                errorBag: 'savePanel',
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                    Swal2.fire('enhorabuena','Se actualizó correctamente','success');
                    displayModalPanel.value = false;
                },
            });
        }else{
            form.post(route('help-boards.store'), {
                errorBag: 'savePanel',
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                    Swal2.fire('enhorabuena','Se registró correctamente','success');
                    displayModalPanel.value = false;
                },
            });
        }
        
    }

    const dropdownItems = ref([]);

    const toggleDropdown = (index) => {
        dropdownItems.value = dropdownItems.value.map((item, i) => ({
            ...item,
            showDropdown: i === index ? !item.showDropdown : false
        }));
    };

    const initializeDropdownItems = () => {
        dropdownItems.value = props.boards.data.map(() => ({ showDropdown: false }));
    };
    const formDelete = useForm({});

    const deletePanel = (index,id) => {
        dropdownItems.value[index].showDropdown = !dropdownItems.value[index].showDropdown;
        Swal2.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: '¡Sí, elimínalo!',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal2.isLoading(), // Evitar cerrar al hacer clic fuera de la alerta mientras está cargando
            preConfirm: () => {
                return new Promise((resolve, reject) => {
                    formDelete.delete(route('help-boards.destroy', id), {
                        preserveScroll: true,
                        onSuccess: () => {
                            resolve();
                        },
                        onError: () => {
                            reject('Error');
                        }
                    });
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
            Swal2.fire(
                'Eliminado!',
                'Su registro ha sido eliminado.',
                'success'
            );
        }
        }).catch((error) => {
            Swal2.fire(
                'Error',
                'Hubo un problema al eliminar el registro.',
                'error'
            );
        });

    }

    const displayModalLevels= ref(false);
    const formLevels = useForm({
        board_id: null,
        level_id: null,
        levels: []
    });

    const showModalLevels = (board) =>{
        formLevels.board_id = board.id;
        formLevels.levels   = board.levels
        displayModalLevels.value = true
    }
    const closeModalLevels = () =>{
        formLevels.board_id = null;
        formLevels.level_id = null;
        displayModalLevels.value = false
    }
   
    const saveBoardLevels = () => {
        formLevels.post(route('helpboardlevels_save'), {
            errorBag: 'saveBoardLevels',
            preserveScroll: true,
            onSuccess: () => { 
                initializeDropdownItems();
                displayModalLevels.value = false;
                Swal2.fire('Enhorabuena','Registro exitoso.','success')
            },
        });
    }
    const formBoardLevel = useForm({});
    const destroyBoardLevel = (id) => {
        Swal2.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: '¡Sí, elimínalo!',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal2.isLoading(), // Evitar cerrar al hacer clic fuera de la alerta mientras está cargando
            preConfirm: () => {
                return new Promise((resolve, reject) => {
                    formBoardLevel.delete(route('helpboardlevels_destroy', id), {
                        preserveScroll: true,
                        onSuccess: () => {
                            resolve();
                        },
                        onError: () => {
                            reject('Error');
                        }
                    });
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
            Swal2.fire(
                'Eliminado!',
                'Su registro ha sido eliminado.',
                'success'
            );
        }
        }).catch((error) => {
            Swal2.fire(
                'Error',
                'Hubo un problema al eliminar el registro.',
                'error'
            );
        });
    }
    initializeDropdownItems();
</script>
<template>
    <AppLayout title="Tableros">
        <div class="max-w-screen-2xl  mx-auto p-4 md:p-6 2xl:p-10">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Centro de Soporte</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Monitoreo</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">
                                <form @submit.prevent="form.get(route('borads.index'))">
                                <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <input v-model="form.search" type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar tablero">
                                    </div>
                                </form>
                            </div>
                            <div  class="col-span-3 sm:col-span-2">
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <div class="px-5  py-5 ">
                            <div class="grid grid-cols-3 gap-4">
                                <div v-can="'help_tableros_nuevo'" class="col-span-4 sm:col-span-1">
                                    <div style="height: 180px;" @click="showModalPanel()" title="Crear Tablero" class="w-full div-con-bordes flex items-center justify-center px-4 py-4">
                                        <div class="cross" ></div>
                                    </div>
                                </div>
                                <div v-for="(board, index) in boards.data" :key="board.id" class="col-span-3 sm:col-span-1">
                                    
                                    <div style="height: 180px;" class="w-full bg-gray-100 max-w-sm  border border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
                                        <div>
                                            <div class="flex relative justify-end px-4 pt-4">
                                                <button
                                                    :id="'dropdownButton'+index"
                                                    @click="toggleDropdown(index)"
                                                    class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                                                    type="button"
                                                >
                                                    <span class="sr-only">Open dropdown</span>
                                                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                                                    ></path>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div
                                                    :id="'dropdown-'+index"
                                                    v-show="dropdownItems[index]?.showDropdown"
                                                    style="margin-top: 44px;"
                                                    class="absolute mt-40 z-40 text-base list-none bg-white divide-y divide-gray-100 shadow w-44 dark:bg-gray-700"
                                                >
                                                    <ul class="py-2" :aria-labelledby="'dropdownButton'+index">
                                                        <li v-can="'help_tableros_editar'">
                                                            <button @click="showModalEditPanel(index)"
                                                            type="button"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                            >Editar</button>
                                                        </li>
                                                        <li v-can="'help_tableros_eliminar'">
                                                            <button @click="deletePanel(index,board.id)"
                                                            type="button"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                            >Eliminar</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center pb-10">
                                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ board.description }}</h5>
                                            <!-- <span class="text-sm text-gray-500 dark:text-gray-400">Visual Designer</span> -->
                                            <div class="flex mb-4 mt-4 space-x-3 sm:mb-6 sm:mt-6">
                                                <button @click="showModalLevels(board)" v-can="'help_tableros_niveles'" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Niveles
                                                </button>
                                                <a v-can="'help_tableros_ticket'" href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">
                                                    Tickets
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <Pagination :data="boards" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              
            
        </div>
    </AppLayout>
    <ModalSmall :show="displayModalPanel" @close="closeModalPanel()" :icon="'/img/nuevo32.png'">
        <template #title>
            Crear Tablero
        </template>
        <template #message>
            Campos Obligatorios *
        </template>
        <template #content>
            <div>
                <InputLabel value="Descripción*" />
                <TextInput
                    v-model="form.description"
                    type="text"
                    class="w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
        </template>
        <template #buttons>
            <DangerButton
                class="mr-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="savePanel"
            >
                <svg v-show="form.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                </svg>
                Guardar
            </DangerButton>
        </template>
    </ModalSmall>
    <ModalSmall :show="displayModalLevels" @close="closeModalLevels()" :icon="'/img/riesgo.png'">
        <template #title>
            Niveles
        </template>
        <template #message>
            Campos Obligatorios *
        </template>
        <template #content>
            <div class="w-full mb-4">
                <div class="flex items-center">   
                    <label for="level_id" class="sr-only">Niveles</label>
                    <div class="relative w-full">
                        <select v-model="formLevels.level_id" id="level_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <template v-for="(level, index) in levels">
                                <option :value="level.id" >{{ level.description }}</option>
                            </template>
                        </select>
                    </div>
                    <button @click="saveBoardLevels()" type="button" class="px-2 py-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg v-show="formLevels.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        <font-awesome-icon v-show="!formLevels.processing" :icon="faPlus" />
                    </button>
                </div>
                <InputError :message="formLevels.errors.level_id" class="mt-2" />
            </div>
            <div class="w-full">
                <table class="w-full table-auto">
                    <thead class="border-b border-stroke">
                        <tr class="bg-gray-50 text-left dark:bg-meta-4">
                            <th class="py-2 font-medium text-black dark:text-white"></th>
                            <th class="py-2 font-medium text-black dark:text-white">Niveles Agregados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(level, index) in formLevels.levels" class="bg-white border-b border-stroke dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-2 bg-white border-b border-stroke dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <div @click="destroyBoardLevel(level.id)">
                                    <font-awesome-icon :icon="faCircleXmark" />
                                </div>
                            </td>
                            <td class="py-2 bg-white border-b border-stroke dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                {{ level.description  }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <template #buttons>
        </template>
    </ModalSmall>
</template>
<style>
.div-con-bordes {
  border-width: 2px;
  border-style: dashed;
  border-color: #63ADF8;
  text-align: center;
  cursor: pointer;
}
.cross {
  width: 80px;
  height: 80px;
  position: relative;
}

.cross:before,
.cross:after {
  content: "";
  position: absolute;
  background-color: #63ADF8;
  transition: background-color 0.3s ease;
}

.cross:before {
  width: 100%;
  height: 2px;
  top: 38px;
  left: 0;
}

.cross:after {
  width: 2px;
  height: 100%;
  top: 0;
  left: 38px;
}

.cross:hover:before,
.cross:hover:after {
  background-color: #4287f5;
  cursor: pointer;
}

.div-con-bordes [title] {
  position: relative;
}

.div-con-bordes [title]:hover:after {
  content: attr(title);
  position: absolute;
  bottom: calc(100% + 4px);
  left: 50%;
  transform: translateX(-50%);
  background-color: black;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  white-space: nowrap;
}
</style>