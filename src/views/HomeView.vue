<template>
  <main>
    <SearchBar @search="handleSearch" />
    <JobList 
      :jobs="jobs" 
      :isLoading="isLoading"
      :error="error"
    />
  </main>
</template>

<script setup lang="ts">
import SearchBar from '../components/SearchBar.vue';
import JobList from '../components/JobList.vue';
import { useJobSearch } from '../composables/useJobSearch';

const { jobs, isLoading, error, performSearch } = useJobSearch();

const handleSearch = (searchParams: { keyword: string; location: string }) => {
  performSearch(searchParams.keyword, searchParams.location);
};

// Initial search on mount
performSearch('', '');
</script>