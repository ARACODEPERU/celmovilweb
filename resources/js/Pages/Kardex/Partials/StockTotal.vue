<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const dataStock = useForm({
  stock_old: '',
  stock_sales: '',
  stock_today: '',
  stock_input: '',
  local: {},
  stock_sales_p: '',
  stock_today_p: '',
  stock_input_p: '',
});

const hasData = ref(false);

onMounted(async () => {
  try {
    const response = await axios.get(route('generalstock'));
    const { data } = response;
    if (data && data.local && data.local.description) {
      dataStock.stock_old = data.stock_old;
      dataStock.stock_sales = data.stock_sales;
      dataStock.stock_today = data.stock_today;
      dataStock.stock_input = data.stock_input;
      dataStock.stock_input_p = ((parseFloat(data.stock_input) / parseFloat(data.stock_old)) * 100).toFixed(2);
      dataStock.stock_sales_p = ((parseFloat(data.stock_sales) / parseFloat(data.stock_old)) * 100).toFixed(2);
      dataStock.stock_today_p = ((parseFloat(data.stock_today)  / parseFloat(data.stock_old)) * 100).toFixed(2);
      dataStock.local = data.local;
      hasData.value = true;
    }
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="mb-4">
    <p  class="dark:text-white">
      {{ dataStock.local.description }}
      <strong> CALZADOS HOY:</strong>
    </p>
  </div>
  <div v-if="hasData" class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
    <!-- Card Item Start -->
    <div class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
      <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
          <img src="/img/caja.png" />
      </div>
      <div class="mt-4 flex items-end justify-between">
        <div>
          <h4 class="text-title-md font-bold text-black dark:text-white">
            {{ dataStock.stock_old }}
          </h4>
          <span class="text-sm font-medium">Inicio día</span>
        </div>
        
        <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
          100%
          <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z"
              fill="" />
          </svg>
        </span>
      </div>
    </div>
    <div class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
      <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
        <img src="/img/puerta.png" />
      </div>
        
      <div class="mt-4 flex items-end justify-between">
        <div>
          <h4 class="text-title-md font-bold text-black dark:text-white">
            {{ dataStock.stock_input }}
          </h4>
          <span class="text-sm font-medium">Ingresos</span>
        </div>

        <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
          {{ dataStock.stock_input_p }}%
          <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z"
              fill="" />
          </svg>
        </span>
      </div>
    </div>
    <!-- Card Item End -->
        
    <!-- Card Item Start -->
    <div
      class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
      <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
        <img src="/img/bienes.png" />
      </div>
        
      <div class="mt-4 flex items-end justify-between">
        <div>
          <h4 class="text-title-md font-bold text-black dark:text-white">
            {{ dataStock.stock_sales }}
          </h4>
          <span class="text-sm font-medium">Vendidos</span>
        </div>

        <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
          {{ dataStock.stock_sales_p }}%
          <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z"
              fill="" />
          </svg>
        </span>
      </div>
    </div>
    <!-- Card Item End -->
        
    <!-- Card Item Start -->
    <div
      class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
      <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
        <img src="/img/en-stock.png" />
      </div>
        
      <div class="mt-4 flex items-end justify-between">
        <div>
          <h4 class="text-title-md font-bold text-black dark:text-white">
            {{ dataStock.stock_today }}
          </h4>
          <span class="text-sm font-medium">Actual</span>
        </div>

        <span class="flex items-center gap-1 text-sm font-medium text-meta-5">
          {{ dataStock.stock_today_p }}%
          <svg class="fill-meta-5" width="10" height="11" viewBox="0 0 10 11" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M5.64284 7.69237L9.09102 4.33987L10 5.22362L5 10.0849L-8.98488e-07 5.22362L0.908973 4.33987L4.35716 7.69237L4.35716 0.0848701L5.64284 0.0848704L5.64284 7.69237Z"
              fill="" />
          </svg>
        </span>
      </div>
    </div>
  </div>
</template>
