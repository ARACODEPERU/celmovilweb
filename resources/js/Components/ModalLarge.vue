<script setup>
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    const props = defineProps({
        onClose: {
            type: Function,
            default: () => {},
        },
        show:{
            type: Boolean,
            default: false,
        },
        icon:{
            type: String,
            default: () => {},
        }
    });
</script>
<template>
  <div v-show="show" class="fixed z-9999 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-800"></div>
      </div>

      <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
        <div class="bg-white dark:bg-gray-800 px-4 pt-5 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-800 sm:mx-0 sm:h-10 sm:w-10">
              
              <img v-if="icon" :src="icon" />
              <svg v-else class="h-6 w-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                <slot name="title" />
              </h3>
              <div class="mt-2">
                <slot name="message" />
              </div>
            </div>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-800 sm:p-6 sm:pb-4">
          <slot name="content" />
        </div>
        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-700 text-right">
          <slot name="buttons" />
          <SecondaryButton @click="onClose">
            Cancel
          </SecondaryButton>
        </div>
      </div>
    </div>
  </div>
</template>
  

  