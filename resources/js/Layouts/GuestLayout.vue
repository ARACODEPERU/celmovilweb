<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const company = computed(() => usePage().props.company || {});
const logoUrl = computed(() => company.value?.logo_url || (company.value?.logo ? '/storage/' + company.value.logo : null));
const companyName = computed(() => company.value?.tradename || company.value?.name || 'Mi Empresa');
const initials = computed(() => {
    const words = companyName.value.trim().split(/\s+/);
    if (words.length === 1) return words[0].slice(0, 2).toUpperCase();
    return (words[0][0] + words[words.length - 1][0]).toUpperCase();
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-boxdark flex flex-col lg:flex-row">
        <!-- Brand Panel (desktop) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0188EE] via-[#016BBE] to-[#013B66] relative overflow-hidden flex-col justify-between p-10 xl:p-16">
            <!-- Decorative shapes -->
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-32 -left-16 w-[28rem] h-[28rem] rounded-full bg-white/5"></div>
            <div class="absolute top-1/3 right-0 w-64 h-64 rounded-full bg-white/5 blur-2xl"></div>

            <div class="relative z-10">
                <span class="inline-flex items-center gap-3">
                    <template v-if="logoUrl">
                        <img :src="logoUrl" alt="Logo" class="h-12 w-auto max-w-[220px] rounded-lg bg-white/95 p-1.5 shadow-lg object-contain" />
                    </template>
                    <template v-else>
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 backdrop-blur text-white text-lg font-bold shadow-lg border border-white/25">
                            {{ initials }}
                        </span>
                    </template>
                    <span class="text-white text-xl font-semibold tracking-wide">{{ companyName }}</span>
                </span>
            </div>

            <div class="relative z-10 max-w-md">
                <h1 class="text-3xl xl:text-4xl font-bold text-white leading-tight">
                    Solución de ventas adaptable y amigable multiplataforma.
                </h1>
                <p class="mt-4 text-blue-100/90 text-base leading-relaxed">
                    Gestiona tus productos, ventas e inventario desde cualquier lugar, en cualquier momento.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-8 text-blue-100/70 text-sm">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Multiplataforma
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Rápido y seguro
                </span>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="w-full lg:w-1/2 flex flex-col">
            <!-- Mobile header with logo -->
            <div class="lg:hidden flex items-center gap-3 px-6 pt-8 pb-2">
                <template v-if="logoUrl">
                    <img :src="logoUrl" alt="Logo" class="h-11 w-auto max-w-[180px] rounded-lg border border-gray-200 dark:border-gray-700 bg-white p-1 object-contain" />
                </template>
                <template v-else>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary text-white text-base font-bold shadow">{{ initials }}</span>
                </template>
                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ companyName }}</span>
            </div>

            <main class="flex-1 flex items-center justify-center p-6 sm:p-10">
                <div class="w-full max-w-md">
                    <slot />
                </div>
            </main>

            <footer class="px-6 pb-6 text-center text-xs text-gray-400 dark:text-gray-500">
                © {{ new Date().getFullYear() }} {{ companyName }} · Todos los derechos reservados
            </footer>
        </div>
    </div>
</template>
