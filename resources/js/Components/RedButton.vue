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
    type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
        <slot />
    </button>
</template>