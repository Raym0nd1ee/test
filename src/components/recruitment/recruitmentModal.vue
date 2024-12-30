<template>
  <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Recruitment Services</h2>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="space-y-6">
        <div v-if="success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
          {{ success }}
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <FormAlert v-if="error" type="error" :message="error" />
          <FormAlert v-if="success" type="success" :message="success" />
          <FormField
            v-model="form.companyName"
            label="Company Name"
            type="text"
            required
          />

          <FormField
            v-model="form.contactPerson"
            label="Contact Person"
            type="text"
            required
          />

          <FormField
            v-model="form.email"
            label="Email"
            type="email"
            required
          />

          <FormField
            v-model="form.phone"
            label="Phone"
            type="text"
            required
          />

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Services Required</label>
            <select
              v-model="form.service"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
            >
              <option value="">Select a Service</option>
              <option value="full-recruitment">Full Recruitment Service</option>
              <option value="candidate-screening">Candidate Screening</option>
              <option value="headhunting">Executive Search/Headhunting</option>
              <option value="consultation">Recruitment Consultation</option>
            </select>
          </div>

          <FormField
            v-model="form.message"
            label="Additional Details"
            type="textarea"
            :rows="4"
            required
          />

          <div class="flex justify-end gap-4">
            <button
              type="button"
              @click="$emit('close')"
              class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="isSubmitting"
              class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90 disabled:opacity-50"
            >
              {{ isSubmitting ? 'Submitting...' : 'Submit Request' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { useRecruitmentServices } from '../../composables/useRecruitmentServices';
import FormField from '../form/FormField.vue';
import FormAlert from '../form/FormAlert.vue';

const props = defineProps<{
  isOpen: boolean;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'success'): void;
}>();

const form = reactive({
  companyName: '',
  contactPerson: '',
  email: '',
  phone: '',
  service: '',
  message: '',
  status:'',
});

const { isSubmitting,error, success, submitRequest } = useRecruitmentServices();

const handleSubmit = async () => {
  const result = await submitRequest(form);
  if (result) {
    emit('success');
    emit('close');
  }
};
</script>