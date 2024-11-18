<template>
  <EmployeesLayout title="Employee Details">
    <div>
      <v-card
        title="Employees Details"
        flat
      >
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="proxyEmployee.name"
                label="Name"
              ></v-text-field>
              <v-text-field
                v-model="proxyEmployee.job_title"
                label="Job Title"
              ></v-text-field>
              <v-text-field
                v-model="proxyEmployee.email"
                label="Email"
              ></v-text-field>
              <v-text-field
                v-model="proxyEmployee.salary"
                label="Salary"
              ></v-text-field>
              <v-text-field
                v-model="proxyEmployee.phone_number"
                label="Phone Number"
              ></v-text-field>
              <v-autocomplete
                v-if="certifications.length"
                v-model="proxyEmployee.certifications"
                :items="certifications"
                item-text="name"
                item-value="id"
                label="Certifications"
                multiple
                :return-object="true"
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
            </v-col>
            <v-col cols="12" md="6">
              <v-card-title>Certifications</v-card-title>
              <v-list-item-group>
                <v-list-item
                  v-for="certification in proxyEmployee.certifications"
                  :key="certification.id"
                >
                  <v-list-item-title><v-chip> + {{ certification.name }}</v-chip></v-list-item-title>
                </v-list-item>
              </v-list-item-group>
            </v-col>

            <v-col cols="12">
              <v-btn
                color="primary"
                @click="updateEmployee"
              >
                Update
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </div>
  </EmployeesLayout>
</template>

<script setup>
import EmployeesLayout from './Layout.vue';
import { onMounted, ref } from 'vue';

const props = defineProps({
  employee: {
    type: Object,
    required: true,
  }
})

const proxyEmployee = ref(props.employee);

const certifications = ref(props.employee.certifications);

const fetchCertifications = async () => {
  const { data } = await axios.get('/api/certifications');
  certifications.value = data;
}

const updateEmployee = async () => {
  let employeeCertifications = proxyEmployee.value.certifications.map(certification => certification.id);
  let employeeState = proxyEmployee.value;

  try {
    await axios.put(`/api/employees/${proxyEmployee.value.id}`, { ...employeeState, certifications: employeeCertifications })
  } catch (error) {
    console.error(error)
  }
}

onMounted(() => {
  fetchCertifications();
})
</script>

<style lang="scss" scoped>

</style>