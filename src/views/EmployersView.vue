<template>
  <div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">For Employers</h1>
    
    <div class="grid md:grid-cols-2 gap-8">
      <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-primary mb-4">Post a Job</h2>
        <p class="text-gray-600 mb-6">
          Reach qualified candidates and find the perfect fit for your organization.
        </p>
        <button 
          @click="showJobPostModal = true"
          class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary/90 transition-colors"
        >
          Post a Job Now
        </button>
      </div>

      <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-primary mb-4">Recruitment Services</h2>
        <p class="text-gray-600 mb-6">
          Let our expert team help you find and attract top talent for your organization.
        </p>
        <button 
          @click="showRecruitmentModal = true"
          class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary/90 transition-colors"
        >
          Learn More
        </button>
      </div>
    </div>

    <div class="mt-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-6">Why Choose Allied Jobs?</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Targeted Reach</h3>
          <p class="text-gray-600">
            Access a pool of qualified candidates specifically interested in your industry.
          </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Expert Support</h3>
          <p class="text-gray-600">
            Get personalized assistance from our experienced recruitment team.
          </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Quality Results</h3>
          <p class="text-gray-600">
            Find the right candidates faster with our advanced matching system.
          </p>
        </div>
      </div>
    </div>

    <JobPostModal
      :is-open="showJobPostModal"
      @close="showJobPostModal = false"
      @success="handleJobPostSuccess"
    />

    <RecruitmentModal
      :is-open="showRecruitmentModal"
      @close="showRecruitmentModal = false"
      @success="handleRecruitmentSuccess"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import JobPostModal from '../components/job/JobPostModal.vue';
import RecruitmentModal from '../components/recruitment/recruitmentModal.vue';

const showJobPostModal = ref(false);
const showRecruitmentModal = ref(false);

const handleJobPostSuccess = () => {
  console.log('Job posted successfully');
};

const handleRecruitmentSuccess = () => {
  console.log('Recruitment request submitted successfully');
};
</script>