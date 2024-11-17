<template>
  <v-pagination
    density="comfortable"
    :model-value="data?.current_page"
    @update:model-value="pageChanged"
    :length="data?.last_page"
    class="my-4"
  ></v-pagination>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({
  data: {
    type: Object,
    default: {},
  },
  useCurrent: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["goTo"]);

const pageChanged = (page) => {
  if (props.useCurrent) {
    router.get(
      window.location.href,
      { page: page },
      {
        preserveState: true,
        preserveScroll: true,
      }
    );
    /* router.get(route(route().current(), {page: page}), {
            preserveScroll: true
        }) */
  } else {
    emit("goTo", page);
  }
};
</script>

<style></style>
