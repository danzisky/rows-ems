<template>
  <CertificationsLayout title="Certifications">
    <div>
      <v-card
        title="Certifications"
        flat
      >
        <template v-slot:text>
          <v-text-field
            v-model="search"
            label="Search"
            prepend-inner-icon="mdi-magnify"
            variant="outlined"
            hide-details
            single-line
          ></v-text-field>
        </template>

        <v-data-table
          :items="certifications"
          :headers="headers"
          :search="search"
          :loading="loading"
          @search="search = $event"
        >
          <template #no-data>
            <v-alert type="info">No certifications found.</v-alert>
          </template>

          <template v-slot:bottom>
            <div class="text-center pt-2">
              <Pagination
                :data="pagination"
                @go-to="fetchCertifications"
              ></Pagination>
            </div>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </CertificationsLayout>
</template>

<script setup>
import { useDebounceFn } from '@vueuse/core';
import CertificationsLayout from './Layout.vue';
import Pagination from '@App/Components/Pagination.vue';
import { ref, watch, onBeforeMount } from 'vue';
import CreateAlert from '../Hooks/CreateAlert';

const certifications = ref([])

const headers = [
  { title: 'ID', value: 'id' },
  { title: 'Name', value: 'name' },
]

const search = ref('')
const loading = ref(false)

const pagination = ref({
  last_page: 1,
  current_page: 1,
})

const fetchCertifications = useDebounceFn(async (page = 1) => {
  loading.value = true

  try {
    const response = await axios.get('api/certifications', { params: { page, search: search.value } })
    certifications.value = response.data
    pagination.value = {
      last_page: response.data.last_page,
      current_page: response.data.current_page,
    }
  } catch (error) {
    CreateAlert.error('An error occurred while fetching certifications.')
    console.error(error)
  } finally {
    loading.value = false
  }
}, 500)

onBeforeMount(() => {
  fetchCertifications()
})


watch(search, () => {
  fetchCertifications()
})
</script>

<style lang="scss" scoped>

</style>