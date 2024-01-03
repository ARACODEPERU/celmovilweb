<script  setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, router, Link  } from '@inertiajs/vue3';
import { Card, CardMeta, Avatar, DirectoryTree } from 'ant-design-vue';
import { ref, watch  } from 'vue';
import ModalLargeXX from '@/Components/ModalLargeXX.vue';
import { Alert } from 'flowbite-vue'

const props = defineProps({
    courses: {
        type: Object,
        default: () => ({}),
    }
});

const openModalContents = ref(false);

const modulesData = ref([]);
const courseName = ref([]);
const loadingContent = ref(false);

const readContent = async (data) => {
    
    modulesData.value = data.map((mol) => (
        {
            key: mol.id,
            title: mol.description,
            children: mol.themes.map((the) => ({
                    key: the.id,
                    title: the.description,
                    children: the.contents.map((con) => ({
                            isLeaf: true,
                            key: con.id,
                            title: con.description,
                            is_file: con.is_file,
                            content: con.content
                        }
                    ))
                }
            ))
        }
    ));
}

const showLine = ref(true);
const showIcon = ref(false);

const showModalContents = async (course) => {
    loadingContent.value = true;
    courseName.value = course.description
    try {
        await readContent(course.modules);
    } finally {
        loadingContent.value = false;
    }

    openModalContents.value = true;
};

const hideModalContents = () => {
    videoHtml.value = null;
    openModalContents.value = false;
};

const expandedKeys = ref([]);
const selectedKeys = ref([]);
const videoHtml = ref(null);
const newWidth = ref(100);
const newHeight = ref(200);

const modifiedContent = (content) => {
  // Copia el contenido original
  let modifiedContent = content;

  // Realiza la sustitución de la altura con un valor dinámico
  modifiedContent = modifiedContent.replace(/width="\d+"/g, `width="${newWidth.value}%"`);
  modifiedContent = modifiedContent.replace(/height="\d+"/g, `height="${newHeight.value}"`);
  return modifiedContent;
};

const onSelect = (selectedKeys, info) => {
    if (info.node && info.node.content !== undefined) {
        if(info.node.is_file){
            let url = info.node.content;
            window.open(url, "_blank");  
        }else{
            videoHtml.value = modifiedContent(info.node.content)
        }
    }
}
</script>

<template>
    <AppLayout title="Estudiantes">
        <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Académico</span>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Estudiante</span>
                    </div>
                </li>
                </ol>
            </nav>
        
            <!-- Breadcrumb End -->
            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <div class="grid grid-cols-6 gap-6">

                    <div v-for="(course, index) in courses" class="col-span-6 sm:col-span-2">
                        <Card @click="showModalContents(course)" hoverable >
                            <!-- <template #cover>
                                <img
                                    style="height: 150px;"
                                    alt="example"
                                    :src="course.image"
                                />
                            </template>
                             -->
                            <template v-if="course.teacher">
                                <CardMeta 
                                    :title="course.teacher.person.full_name" 
                                    :description="course.description">
                                    <template #avatar>
                                        <Avatar :src="course.teacher.person.image" />
                                    </template>
                                </CardMeta>
                            </template>
                            <template v-else>
                                <CardMeta 
                                    :description="course.description">
                                </CardMeta>
                            </template>
                            <template #actions>
                                <p>Ir al Curso</p>
                            </template>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
        <ModalLargeXX
            :onClose="hideModalContents"
            :show="openModalContents"
            :icon="'/img/carpeta.png'"
        >
            <template #title>
                {{ courseName }}
            </template>
            <template #message>
                Módulos temas y contenidos del curso
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <template v-if="loadingContent">
                            <div class="flex items-center justify-center w-56 h-56 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <DirectoryTree
                                :height="233"
                                v-model:expandedKeys="expandedKeys"
                                v-model:selectedKeys="selectedKeys"
                                :tree-data="modulesData"
                                @select="onSelect"
                            ></DirectoryTree>
                        </template>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <div v-html="videoHtml"></div>
                    </div>
                </div>
            </template>
        </ModalLargeXX>
    </AppLayout>
</template>