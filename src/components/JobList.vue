<script setup lang="ts">
import { ref } from 'vue';
import type { Job } from '../types/Job';
import LoadingSpinner from './LoadingSpinner.vue';
import ErrorMessage from './ErrorMessage.vue';
import ApplicationModal from './ApplicationModal.vue';

defineProps<{
  jobs: Job[];
  isLoading: boolean;
  error: string | null;
}>();

const selectedJob = ref<Job | null>(null);
const showApplicationModal = ref(false);

const handleApply = (job: Job) => {
  selectedJob.value = job;
  showApplicationModal.value = true;
};

const handleApplicationSuccess = () => {
  // You can add a success message or notification here
  console.log('Application submitted successfully');
};
</script>

<template>
  <div class="container mx-auto px-4 py-12">
    <div v-if="isLoading" class="py-8">
      <LoadingSpinner />
    </div>

    <div v-else-if="error" class="py-8">
      <ErrorMessage :message="error" />
    </div>

    <div v-else-if="jobs.length === 0" class="text-center py-8">
      <p class="text-gray-600">No jobs found matching your search criteria.</p>
    </div>

    <div v-else class="grid gap-6">
      <div
        v-for="job in jobs"
        :key="job.id"
        class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow"
      >
        <div class="flex justify-between items-start">
          <div>
            <h3 class="text-xl font-semibold text-gray-900">{{ job.title }}</h3>
            <p class="text-gray-600 mt-1">{{ job.company }}</p>
            <div class="flex gap-4 mt-2">
              <span class="text-gray-500 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ job.location }}
              </span>
              <span class="text-gray-500 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{ job.type }}
              </span>
            </div>
          </div>
          <div class="text-right">
            <span class="text-primary font-semibold">{{ job.salary }}</span>
            <p class="text-sm text-gray-500 mt-1">Posted {{ job.posted_date }}</p>
          </div>
        </div>
        <p class="text-gray-600 mt-4">{{ job.description }}</p>
        <div class="mt-4">
          <button 
            @click="handleApply(job)"
            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary/90 transition-colors"
          >
            Apply Now
          </button>
        </div>
      </div>
    </div>

    <ApplicationModal
      v-if="selectedJob"
      :job="selectedJob"
      :is-open="showApplicationModal"
      @close="showApplicationModal = false"
      @success="handleApplicationSuccess"
    />
  </div>
</template>