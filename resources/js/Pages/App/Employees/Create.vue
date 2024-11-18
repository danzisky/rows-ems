<template>
  <EmployeesLayout title="Create Employee">
    <div>
      <v-card
        title="Employees"
        flat
      >
        <v-card-title>
          <h3>Create Employee</h3>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="createEmployee">
            <v-text-field
              v-model="form.name"
              label="Name"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.job_title"
              label="Job Title"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.email"
              label="Email"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.salary"
              label="Salary"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.phone_number"
              label="Phone Number"
              required
            ></v-text-field>
            <v-autocomplete
              v-if="certifications.length"
              v-model="form.certifications"
              :items="certifications"
              item-text="name"
              item-value="id"
              label="Certifications"
              multiple
              required
              :return-object="false"
              clearable
            >
              <template #selection="{ item }">
                {{ item.raw.name }},
              </template>
              <template #item="{ props, item }">
                  <v-list-item
                    v-bind="props"
                    :title="item.raw.name"
                  >
                  </v-list-item>
              </template>
            </v-autocomplete>
            <v-btn
              type="submit"
              color="primary"
            >
              Create
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </div>
  </EmployeesLayout>
</template>

<script setup>
import EmployeesLayout from './Layout.vue';
import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const form = ref({
  name: '',
  job_title: '',
  email: '',
  salary: '',
  phone_number: '',
  certifications: []
});

const certifications = ref([]);

const createEmployee = () => {
  axios.post('/api/employees', form.value, {
    headers: {
      'X-CSRF-TOKEN': window.Laravel.csrfToken
    }
  })
    .then(response => {
      console.log(response.data)
      router.get(route('employees.index'))
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchCertifications = () => {
  axios.get('/api/certifications')
    .then(response => {
      certifications.value = response.data?.map(certification => {
        return {
          id: certification.id,
          name: certification.name,
        }
      })
    })
    .catch(error => {
      console.error(error)
    })
}

onMounted(() => {
  fetchCertifications()
})
</script>

<style lang="scss" scoped>

</style>