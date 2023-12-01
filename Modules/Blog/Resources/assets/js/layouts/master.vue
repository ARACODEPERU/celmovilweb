<script setup>
    import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Navigation from '@/Components/Navigation.vue';

defineProps({
    title: String,
});
const isActive = useForm({
    name: localStorage.getItem('option')
});

const activeRouteGet = (option) => {
    localStorage.setItem('option', option);
}
</script>

<template>
    <div>
        <Head :title="title" />
        <Banner />
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Navigation></Navigation>
            <!-- Page Content -->
            <main>
                
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">

                    <li class="mr-2">
                        <a 
                            @click="activeRouteGet('categories')" 
                            :href="route('blog-category.index')" 
                            :class="isActive.name == 'categories' ? 'inline-block p-4 text-blue-600 bg-gray-100 active rounded-t-lg dark:bg-gray-800 dark:text-blue-500' : 'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'" 
                        >Categorías</a>
                    </li>
                    <li class="mr-2">
                        <a 
                            @click="activeRouteGet('articles')" 
                            :href="route('blog-article.index')" 
                            :class="isActive.name == 'articles' ? 'inline-block p-4 text-blue-600 bg-gray-100 active rounded-t-lg dark:bg-gray-800 dark:text-blue-500' : 'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'" 
                        >Artículos</a>
                    </li>
                </ul>

               <slot />
            </main>
        </div>
    </div>
</template>
