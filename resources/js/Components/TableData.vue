<template>
  <table class="w-full text-sm text-left text-gray-900 dark:text-gray-200">
    <thead>
      <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <th v-for="header in headers" :key="header.key" :class="header.classes || "px-4 py-2.5 font-medium text-black dark:text-white"">
          {{ header.label }}
        </th>
      </tr>
    </thead>
    <tbody>
      <template v-if="items && items.length">
        <tr v-for="(item, index) in items" :key="itemKey(item, index)" class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
          <template v-for="header in headers" :key="header.key">
            <td v-if="header.key === "_actions"" :class="header.classes || "text-center"">
              <slot name="actions" :item="item" />
            </td>
            <td v-else :class="header.classes || """>
              <slot :name="`cell-`" :item="item">{{ item[header.key] }}</slot>
            </td>
          </template>
        </tr>
      </template>
      <tr v-else>
        <td :colspan="headers.length" class="px-4 py-6 text-center text-gray-500">
          <slot name="empty">{{ emptyMessage || "Sin resultados" }}</slot>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
const props = defineProps({
  items: { type: Array, default: () => [] },
  headers: { type: Array, default: () => [] },
  emptyMessage: { type: String, default: "Sin resultados" },
});
const itemKey = (item, index) => (item && item.id ? item.id : index);
</script>
