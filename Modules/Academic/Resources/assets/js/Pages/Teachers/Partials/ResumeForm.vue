<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { Spinner } from 'flowbite-vue'
import { onMounted } from 'vue'
import swal from 'sweetalert2';
import Keypad from '@/Components/Keypad.vue';

const props = defineProps({
    teacher:{
        type: Object,
        default: () => ({}),
    },
    faCheck: {
        type: Object,
        default: () => ({}),
    },
    faTrashAlt: {
        type: Object,
        default: () => ({}),
    },
    resumes: {
        type: Object,
        default: () => ({}),
    }
});


const formResume = useForm({
    teacher_id: props.teacher.id,
    experiences: props.resumes
});


const createResumeExperience = (data, index, id) => {

    formResume.experiences[index].loading = true;
    axios.post(route('aca_teachers_work_experience_store'),data).then((res) => {

        formResume.experiences[index].id = res.data.id;
        formResume.experiences[index].destroy = true;

        if(!id){
            let ar = {
                destroy: false,
                loading: false,
                id: null,
                teacher_id: props.teacher.id,
                description: null
            };

            formResume.experiences.push(ar);
        }
        formResume.experiences[index].loading = false;
    });
}
const initAddItem = () => {
    formResume.experiences.push({
        destroy: false,
        loading: false,
        id: null,
        teacher_id: props.teacher.id,
        description: null
    });
};

onMounted(() => {
    initAddItem();
});

const destroyExperience = (id, index) => {
    swal.fire({
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
            return axios.delete(route('aca_teachers_work_experience_destroy', id)).then((res) => {
                if (!res.data.success) {
                    swal.showValidationMessage(res.data.message)
                }
                return res
            });
        },
        allowOutsideClick: () => !swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            swal.fire({
                title: 'Enhorabuena',
                text: 'Se Eliminó correctamente',
                icon: 'success',
            });
            if(index>0){
                formResume.experiences.splice(index,1);
            }
        }
    });
}

</script>
<template>
    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-6 sm:col-span-4">
            <div class="p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="space-y-6">
                    <h5 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Experiencias</h5>
                    <template v-for="(item, index) in formResume.experiences">
                        <div class="flex items-center mt-2">   
                            <label :for="'simple-search-'+index" class="sr-only">Write here</label>
                            <div class="relative w-full">
                                <input v-model="item.description" type="text" :id="'simple-search-'+index" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aquí..." required>
                            </div>
                            <button @click="createResumeExperience(item,index,item.id)" type="button" class="p-2.5 ml-2 text-sm font-medium text-white bg-gray-800 rounded-lg border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                <Spinner v-if="item.loading" />
                                <font-awesome-icon v-else :icon="faCheck" />
                            </button>
                            <button @click="destroyExperience(item.id,index)" v-if="item.destroy" type="button" class="p-2.5 ml-2 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <font-awesome-icon :icon="faTrashAlt" />
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
    </div>
    <div class="grid grid-cols-6 gap-6 mt-4">
        <div class="col-span-6">
            <Keypad>
                <template #botones>
                    <Link :href="route('aca_teachers_list')"  class="ml-2 inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Ir al Listado</Link>
                </template>
            </Keypad>
        </div>
    </div>
</template>