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
          <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="filter.search"
                  label="Search"
                  prepend-inner-icon="mdi-magnify"
                  variant="outlined"
                  hide-details
                  single-line
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-range-slider
                  v-model="salaryRange"
                  label="Salary Range"
                  min="0"
                  max="100000"
                  step="1000"
                  hide-details
                >
                  <template #prepend>
                    <div class="max-lg:hidden">
                      <v-text-field
                        v-model="salaryRange[0]"
                        style="width: 100px"
                        type="number"
                        variant="outlined"
                        hide-details
                        single-line
                        ></v-text-field>
                    </div>
                  </template>
                  <template #append>
                    <div class="max-lg:hidden">
                      <v-text-field
                        v-model="salaryRange[1]"
                        style="width: 100px"
                        type="number"
                        variant="outlined"
                        hide-details
                        single-line
                      ></v-text-field>
                    </div>
                  </template>
                </v-range-slider>
                <div class="lg:hidden pt-6">
                  <div class="flex justify-between gap-4">
                    <v-text-field
                      v-model="salaryRange[0]"
                      style="width: 100px"
                      type="number"
                      variant="outlined"
                      hide-details
                      single-line
                      ></v-text-field>
                      <v-text-field
                        v-model="salaryRange[1]"
                        style="width: 100px"
                        type="number"
                        variant="outlined"
                        hide-details
                        single-line
                      ></v-text-field>
                  </div>
                </div>
              </v-col>
          </v-row>
          <v-divider class="my-4"></v-divider>
          <v-row>
            <v-col cols="12" md="6">
              <v-select
                v-model="filter.sort_by"
                :items="headers.filter(h => h.value !== 'actions').map(h => h.value)"
                label="Sort By"
                hide-details
              ></v-select>
            </v-col>
            <v-col cols="12" md="6">
              <v-select
                v-model="filter.order"
                :items="['asc', 'desc']"
                label="Order"
                hide-details
              ></v-select>
            </v-col>
          </v-row>
        </template>

        <v-data-table
          :items="employees"
          :headers="headers"
          :search="filter.search"
          :loading="loading"
          @search="filter.search = $event"
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
import { ref, onMounted, watch, reactive } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import CreateAlert from '../Hooks/CreateAlert';

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

const salaryRange = ref([0, 100000])
const filter = reactive({
  search: '',
  sort_by: 'created_at',
  order: 'desc',
})
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

  axios.get('/api/employees', {
      params: {
        page,
        search: filter.search,
        sort_by: filter.sort_by,
        order: filter.order,
        min_salary: salaryRange.value[0],
        max_salary: salaryRange.value[1],
      }
    })
    .then(response => {
      employees.value = response.data.data
      pagination.value = {
        last_page: response.data.last_page,
        current_page: response.data.current_page,
      }
    })
    .catch(error => {
      console.error(error)
      CreateAlert.error('An error occurred while fetching employees.')
    })
    .finally(() => {
      loading.value = false
    })
}, 500)

const deleteEmployee = (employee) => {
  if (confirm('Are you sure you want to delete this employee?')) {
    axios.delete(`/api/employees/${employee.id}`)
      .then(() => {
        CreateAlert.success('Employee deleted successfully.')
        employees.value = employees.value.filter(e => e.id !== employee.id)
      })
      .catch(error => {
        console.error(error)
        CreateAlert.error('An error occurred while deleting the employee.')
      })
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleString()
}

watch([filter, salaryRange], () => {
  fetchEmployees()
})
</script>

<style lang="scss" scoped>

</style>