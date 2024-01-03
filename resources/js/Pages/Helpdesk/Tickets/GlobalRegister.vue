<script setup>
import { faScrewdriverWrench, faFolderOpen } from "@fortawesome/free-solid-svg-icons";
import { 
    ConfigProvider, 
    Drawer,
    Row, 
    Col, 
    Form, 
    FormItem, 
    TypographyTitle, 
    Select,
    SelectOption,
    Textarea,
    Input, 
    Button, 
    Space, 
    Badge 
} from 'ant-design-vue';
import { ref, onMounted } from 'vue';

const token = '2|a6BgqSpoYeppRExixUrZ8OPgy6TcsFwTYREn72z22ccdea3f';

const form = ref({
    category_id: null,
    incident_id: null,
    incident_description: '',
    type: '',
    approver: '',
    dateTime: null,
    description: '',
});

const helpCategories = ref([]);
const helpThemesQuestions = ref([]);

const open = ref(false);
    const childrenDrawer = ref(false);

const showDrawer = () => {
    open.value = true;
};
  
const onClose = () => {
    open.value = false;
};
const showChildrenDrawer = () => {
    childrenDrawer.value = true;
};

const getRecords = () => {
    axios.get(route('api_helpdesk_client_records'), {
        headers: {
            'Authorization': 'Bearer ' + token,
        }
    }).then((response) => {
        if (response.data && response.data.categories) {
            helpCategories.value = response.data.categories;
        } else {
            console.error('La respuesta no contiene la clave "categories".', response);
        }
    }).catch((error) => {
        console.error('Error en la solicitud:', error);
    });
}

const handleChangeCategory = () => {
    axios.get(route('api_helpdesk_client_themes_questions',form.value.category_id), {
        headers: {
            'Authorization': 'Bearer ' + token,
        }
    }).then((response) => {
        if (response.data && response.data.incidents) {
            helpThemesQuestions.value = response.data.incidents;
        } else {
            console.error('La respuesta no contiene la clave "categories".', response);
        }
    }).catch((error) => {
        console.error('Error en la solicitud:', error);
    });
}

onMounted(() => {
    getRecords();
});
</script>
  
<template>
    <ConfigProvider>
        <Badge count="Ayuda">
            <button @click="showDrawer" type="button" class="p-2.5 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                <font-awesome-icon class="w-5 h-5" :icon="faScrewdriverWrench" />
                <span class="sr-only">Icon description</span>
            </button>
        </Badge>
        <Drawer
            title="SERVICIO DE AYUDA ARACODE"
            :width="720"
            :open="open"
            :body-style="{ paddingBottom: '80px' }"
            :footer-style="{ textAlign: 'right' }"
            @close="onClose"
        >
            <TypographyTitle :level="3">REGISTRAR  SOLICITUD DE ATENCIÓN</TypographyTitle>
            <Form :model="form" layout="vertical">
                <Row :gutter="16">
                    <Col :span="8">
                        <FormItem
                            label="Categoría"
                            name="category_id"
                           
                        >
                            <Select
                                v-model:value="form.category_id"
                                style="width: 100%"
                                @change="handleChangeCategory"
                                :options="helpCategories.map((item) => ({value: item.id, label: item.description}))"
                            >
                            </Select>
                        </FormItem>
                    </Col>
                    <Col :span="16">
                        <FormItem
                            label="Tema"
                            name="theme"
                            
                        >
                            <Select
                                ref="select"
                                v-model:value="form.incident_id"
                                style="width: 100%"
                                :allowClear="true"
                            >
                                <SelectOption :value="9999999999">Otros</SelectOption>
                                <SelectOption v-for="ques in helpThemesQuestions" :value="ques.id">{{ ques.description }}</SelectOption>
                            </Select>
                        </FormItem>
                    </Col>
                </Row>
                <Row :gutter="16">
                    <Col :span="24">
                        <FormItem
                            label="Descripción"
                            name="incident_description"
                        >
                            <Textarea style="width: 100%" v-model:value="form.incident_description" :rows="4" placeholder="Descripción de la incidencia" />
                        </FormItem>
                    </Col>
                </Row>
            </Form>
            <template #extra>
                <Space>
                    <button @click="onClose" type="button" class="text-sm px-3 py-2 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Cerrar</button>
                    <button @click="showChildrenDrawer" type="button" class="px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        <font-awesome-icon :icon="faFolderOpen" />
                        Manuales
                    </button>
                    <button @click="onClose" type="button" class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enviar Solicitud</button>
                </Space>
            </template>
            <Drawer v-model:open="childrenDrawer" title="Two-level Drawer" width="320" :closable="false">
                <Button type="primary" @click="showChildrenDrawer">This is two-level drawer</Button>
            </Drawer>
        </Drawer>
    </ConfigProvider>
</template>
  

  