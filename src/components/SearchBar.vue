<script setup lang="ts">
import { ref } from 'vue';

const emit = defineEmits(['search']);

const keyword = ref('');
const location = ref('');

const handleSearch = () => {
  emit('search', { keyword: keyword.value, location: location.value });
};
</script>

<template>
  <div class="bg-primary py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-white text-center mb-8">
        Find Your Dream Job
      </h2>
      <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              What
            </label>
            <input
              type="text"
              v-model="keyword"
              placeholder="Job title, keywords, or company"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Where
            </label>
            <input
              type="text"
              v-model="location"
              placeholder="City or region"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
            />
          </div>
        </div>
        <button
          @click="handleSearch"
          class="w-full mt-4 bg-primary text-white py-3 px-6 rounded-md hover:bg-primary/90 transition-colors"
        >
          Search Jobs
        </button>
      </div>
    </div>
  </div>
</template>