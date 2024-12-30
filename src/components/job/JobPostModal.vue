<!-- src/components/job/JobPostModal.vue -->
<template>
  <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Post a New Job</h2>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-6">
        <FormAlert v-if="error" type="error" :message="error" />
        <FormAlert v-if="success" type="success" :message="success" />

        <FormField
          v-model="form.title"
          label="Job Title"
          type="text"
          required
        />

        <FormField
          v-model="form.company"
          label="Company Name"
          type="text"
          required
        />

        <FormField
          v-model="form.location"
          label="Location"
          type="text"
          required
        />

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
          <select
            v-model="form.type"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
          >
            <option value="">Select Job Type</option>
            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
            <option value="Contract">Contract</option>
            <option value="Temporary">Temporary</option>
            <option value="Internship">Internship</option>
          </select>
        </div>

        <FormField
          v-model="form.salary"
          label="Salary Range"
          type="text"
          required
        />

        <FormField
          v-model="form.description"
          label="Job Description"
          type="textarea"
          :rows="6"
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
            {{ isSubmitting ? 'Posting...' : 'Post Job' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { useJobPost } from '../../composables/useJobPost';
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
  title: '',
  company: '',
  location: '',
  type: '',
  description: '',
  salary: ''
});

const { isSubmitting, error, success, postJob } = useJobPost();

const resetForm = () => {
  form.title = '';
  form.company = '';
  form.location = '';
  form.type = '';
  form.description = '';
  form.salary = '';
};

const handleSubmit = async () => {
  const result = await postJob(form);
  if (result) {
    emit('success');
    emit('close');
    resetForm();
  }
};
</script>