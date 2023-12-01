<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>
<template>
    <button 
    :disabled="disabled"
    :style="disabled ? 'cursor: not-allowed': ''"
    :type="type" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
    <slot />
    </button>
</template>