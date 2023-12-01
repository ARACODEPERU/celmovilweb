<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-col items-center md:flex-row md:justify-end">

        <Link :href="route('dashboard')" class="mr-2 inline-flex items-center justify-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest whitespace-normal hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
            Panel de Inicio
        </Link>
        <slot name="botones" />

    </div>
</template>
