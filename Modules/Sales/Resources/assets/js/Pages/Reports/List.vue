<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Link } from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        AppLayout
    },
    data() {
        return {
            locals: []
        }
    },
    methods: {
        fetchData() {
            axios.get(route('get_locals'))
                .then(response => {
                    this.locals = response.data;
                })
                .catch(err => {
                    console.log(123, err);
                });
        }
    },
    mounted() {
        this.fetchData();
    }
}
</script>


<template>
    <AppLayout title="Reportes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reportes
            </h2>
        </template>
        <div class="relative p-4">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-4 sm:col-span-1">
                    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Ventas</h2>
                        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>
                                <Link :href="route('sales_report_dates')">Reporte de ventas entre fechas(por locales)</Link>
                            </li>

                            <li>
                                <Link :href="route('sale_report',)">Reporte de ventas ANTERIOR  fechas(todos los locales )</Link>
                            </li>
                            <li>
                                <Link :href="route('report_payment_method_totals')">Reporte Totales de método de pago(por locales)</Link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-span-4 sm:col-span-1">
                    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Inventario</h2>
                        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400" id="locales">
                            <li>
                                <Link :href="route('inventory_report')" target="_blank">Reporte de todos los productos(todos los locales)</Link>
                            </li>

                            <li v-for="local in locals" :key="local.id">
                                <Link :href="route('inventory_report_by_local', local.id)" target="_blank">Reporte de productos(De: {{ local.description }})</Link>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
