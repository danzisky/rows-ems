<template>
  <Head :title="title" />

  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> {{ title }} </h2>
      </template>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <slot></slot>
        </div>
      </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  title: {
    type: String,
    default: 'Certifications'
  }
})
</script>