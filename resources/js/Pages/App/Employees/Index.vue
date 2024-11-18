<template>
  <EmployeesLayout title="Employees">
    <div>
      <v-btn
        @click="router.get(route('employees.create'))"
        color="primary"
        to="create"
        append-icon="mdi-plus"
        class="mb-4"
      >
        Add Employee
      </v-btn>
      <v-card
        title="Employees"
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
          :items="employees"
          :headers="headers"
          :search="search"
          :loading="loading"
          @search="search = $event"
        >
          <template #item.name="{ item }">
            <Link method="get" as="button" type="button" :href="route('employees.show', { employee: item.id })" class="underline underline-offset-2 hover:text-blue-500" > {{ item.name }} </Link>
          </template>
          <template #item.created_at="{ item }">
            {{ formatDate(item.created_at) }}
          </template>

          <template #item.actions="{ item }">
            <div class="flex">
              <v-btn color="primary" @click="router.get(route('employees.show', { employee: item.id }))" :params="{ id: item.id }" icon="mdi-pencil-outline" variant="text"></v-btn>
              <v-btn color="error" @click="deleteEmployee(item)" icon="mdi-delete-outline" variant="text"></v-btn>
            </div>
          </template>

          <template #no-data>
            <v-alert type="info">No employees found.</v-alert>
          </template>

          <template v-slot:bottom>
            <div class="text-center pt-2">
              <Pagination
                :data="pagination"
                @go-to="fetchEmployees"
              ></Pagination>
            </div>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </EmployeesLayout>
</template>

<script setup>
import { useDebounceFn } from '@vueuse/core';
import EmployeesLayout from './Layout.vue';
import Pagination from '@App/Components/Pagination.vue';
import { ref, onMounted, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const employees = ref([])

const headers = [
  { title: 'ID', value: 'id' },
  { title: 'Name', value: 'name' },
  { title: 'Title', value: 'job_title' },
  { title: 'Email', value: 'email' },
  { title: 'Created At', value: 'created_at' },
  { title: 'Salary', value: 'salary' },
  { title: 'Phone', value: 'phone_number' },
  { title: 'Actions', value: 'actions' }
]

const search = ref('')
const loading = ref(false)

const pagination = ref({
  last_page: 1,
  current_page: 1,
})

onMounted(() => {
  fetchEmployees()
})

const fetchEmployees = useDebounceFn((page = 1) => {
  loading.value = true
  
  axios.get('/api/employees', { params: { page, search: search.value } })
    .then(response => {
      employees.value = response.data.data
      pagination.value = {
        last_page: response.data.last_page,
        current_page: response.data.current_page,
      }
    })
    .catch(error => {
      console.error(error)
    })
    .finally(() => {
      loading.value = false
    })
}, 500)

const deleteEmployee = (employee) => {
  if (confirm('Are you sure you want to delete this employee?')) {
    axios.delete(`/api/employees/${employee.id}`)
      .then(() => {
        employees.value = employees.value.filter(e => e.id !== employee.id)
      })
      .catch(error => {
        console.error(error)
      })
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleString()
}

watch(search, () => {
  fetchEmployees()
})
</script>

<style lang="scss" scoped>

</style>