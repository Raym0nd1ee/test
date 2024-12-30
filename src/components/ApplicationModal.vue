<script setup lang="ts">
import { ref } from 'vue';
import type { Job } from '../types/Job';
import type { JobApplication } from '../types/Application';
import { submitApplication } from '../services/applicationService';

const props = defineProps<{
  job: Job;
  isOpen: boolean;
}>();

const emit = defineEmits(['close', 'success']);

const fullName = ref('');
const email = ref('');
const phone = ref('');
const coverLetter = ref('');
const resume = ref<File | null>(null);
const isSubmitting = ref(false);
const error = ref<string | null>(null);

const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files && input.files.length > 0) {
    resume.value = input.files[0];
  }
};

const handleSubmit = async () => {
  try {
    isSubmitting.value = true;
    error.value = null;

    const application: JobApplication = {
      jobId: props.job.id,
      fullName: fullName.value,
      email: email.value,
      phone: phone.value,
      coverLetter: coverLetter.value,
      resume: resume.value,
    };

    const response = await submitApplication(application);
    
    if (response.success) {
      emit('success');
      emit('close');
      resetForm();
    } else {
      error.value = response.message;
    }
  } catch (e) {
    error.value = 'Failed to submit application. Please try again.';
  } finally {
    isSubmitting.value = false;
  }
};

const resetForm = () => {
  fullName.value = '';
  email.value = '';
  phone.value = '';
  coverLetter.value = '';
  resume.value = null;
  error.value = null;
};
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Apply for {{ job.title }}</h2>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input
            v-model="fullName"
            type="text"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
          <input
            v-model="phone"
            type="tel"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Resume</label>
          <input
            type="file"
            accept=".pdf,.doc,.docx"
            @change="handleFileChange"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
          />
          <p class="text-sm text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
          <textarea
            v-model="coverLetter"
            rows="4"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
          ></textarea>
        </div>

        <div v-if="error" class="text-red-600 text-sm">{{ error }}</div>

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
            {{ isSubmitting ? 'Submitting...' : 'Submit Application' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>