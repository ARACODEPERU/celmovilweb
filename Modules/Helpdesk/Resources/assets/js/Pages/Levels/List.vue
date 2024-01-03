<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { faTrashAlt, faPencilAlt, faUserGear} from "@fortawesome/free-solid-svg-icons";
    import { ref } from 'vue';
    import Keypad from '@/Components/Keypad.vue';
    import Swal2 from 'sweetalert2';
    import { Link,useForm } from '@inertiajs/vue3';
    import ModalSmall from '@/Components/ModalSmall.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import { ConfigProvider, Select } from 'ant-design-vue';
    const props = defineProps({
        users: {
            type: Object,
            default: () => ({}),
        },
        levels: {
            type: Object,
            default: () => ({}),
        }
    });

    const formDelete = useForm({});

    const destroyLevel = (id) => {
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
                    formDelete.delete(route('help-level.destroy', id), {
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

    const displayModalMembers = ref(false);
    const formMembers= useForm({
        level_id: null,
        user_ids: []
    });

    const openModalMembers = (level) => {
        formMembers.level_id = level.id;
        const objeto = level.users;
        for (var i = 0; i < objeto.length; i++) {
            var elemento = objeto[i];
            formMembers.user_ids[i] = elemento.id
        }
        displayModalMembers.value = true;
    }
    const closeModalMembers = () => {
        formMembers.user_ids = [];
        displayModalMembers.value = false;
    }

    const saveLevelMembers = () => {
        formMembers.post(route('helpleveluser_save'), {
            errorBag: 'saveLevelMembers',
            preserveScroll: true,
            onSuccess: () => { 
                formMembers.reset();
                displayModalMembers.value = false;
                Swal2.fire('Enhorabuena','Registro exitoso.','success')
            },
        });
    }

const filterOption = (input, option) => {
    const inputValueLower = input.toLowerCase();
    const optionTitleLower = option.label.toLowerCase();
    return optionTitleLower.includes(inputValueLower);
};
</script>
<template>
    <AppLayout title="Niveles">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Centro de Soporte</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Niveles</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Breadcrumb End -->

            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <div class="rounded-sm border border-stroke bg-white  shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="w-full p-4 border-b border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-3 sm:col-span-1">

                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <Keypad>
                                    <template #botones>
                                        <Link v-can="'help_nivel_nuevo'" :href="route('help-level.create')" class="flex items-center justify-center inline-block px-6 py-2.5 bg-blue-900 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                        Nuevo
                                        </Link>
                                    </template>
                                </Keypad>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                        <thead class="border-b border-stroke">
                            <tr class="bg-gray-50 text-left dark:bg-meta-4">
                                <th class="w-4 py-2 px-2 font-medium text-black dark:text-white xl:pl-11">#</th>
                                <th class="w-8 py-2 px-2 text-center font-medium text-black dark:text-white">
                                    Acción
                                </th>
                                <th class="py-2 px-2 font-medium text-black dark:text-white">
                                    Descripción
                                </th>
                                <th class="py-2 px-2 font-medium text-black dark:text-white">
                                    Estado
                                </th>
                            </tr>
                        </thead>
                            <tbody>
                                <tr v-for="(level, index) in levels" :key="level.id" >
                                    <td class="border-b border-stroke py-2 px-2 dark:border-strokedark xl:pl-11">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="text-center border-b border-stroke py-2 px-2 dark:border-strokedark xl:pl-11">
                                        <div class="flex items-center space-x-3.5">
                                            <Link v-permission="'help_nivel_editar'" title="Editar" :href="route('help-level.edit',level.id)" class="mr-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                <font-awesome-icon :icon="faPencilAlt" />
                                            </Link>
                                            <button title="Miembros" type="button" class="mr-1 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center mr-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                            @click="openModalMembers(level)"
                                            >
                                            <font-awesome-icon :icon="faUserGear" />
                                            </button>
                                            <button v-permission="'help_nivel_eliminar'" type="button" class="text-white bg-red-800 border border-red-700 focus:outline-none hover:bg-red-100 focus:ring-4 focus:ring-red-200 font-medium rounded-full text-sm px-2 py-1.5 mr-1 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                @click="destroyLevel(level.id)"
                                                title="Eliminar"
                                                >
                                                <font-awesome-icon :icon="faTrashAlt" />
                                            </button>
                                        </div>
                                    </td>
                                    <td class="border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        {{ level.description }}
                                    </td>
                                    <td class="border-b border-stroke py-2 px-2 dark:border-strokedark">
                                        <span v-if="level.status" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Activo</span>
                                        <span v-else class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Inactivo</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
    <ModalSmall :show="displayModalMembers" :onClose="closeModalMembers" :icon="'/img/seguidores.png'">
        <template #title>Miembros</template>
        <template #message>Elegir y guardar cambios</template>
        <template #content>
            <ConfigProvider>
                <Select
                    v-model:value="formMembers.user_ids"
                    mode="multiple"
                    show-search
                    style="width: 100%;"
                    placeholder="Please select"
                    :options="users.map((obj) => ({ value: obj.id, label: obj.name }))"
                    :dropdownStyle="{ zIndex: 10001 }"
                    :filter-option="filterOption"
                ></Select>
            </ConfigProvider>
        </template>
          <template #buttons>
            <DangerButton
                :class="{ 'opacity-25': formMembers.processing }" :disabled="formMembers.processing"
                class="mr-3"
                @click="saveLevelMembers()"
            >
                <svg v-show="formMembers.processing" aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                </svg>
                Guardar cambios
            </DangerButton>
          </template>
    </ModalSmall>
</template>
