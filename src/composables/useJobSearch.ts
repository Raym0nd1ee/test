import { ref } from 'vue';
import type { Job } from '../types/Job';
import { searchJobs } from '../services/jobService';
import { getErrorMessage } from '../utils/errorHandling';

export function useJobSearch() {
  const jobs = ref<Job[]>([]);
  const isLoading = ref(false);
  const error = ref<string | null>(null);

  const performSearch = async (keyword: string, location: string) => {
    isLoading.value = true;
    error.value = null;

    try {
      const results = await searchJobs(keyword, location);
      jobs.value = results;
    } catch (e) {
      error.value = getErrorMessage(e);
      jobs.value = [];
    } finally {
      isLoading.value = false;
    }
  };

  return {
    jobs,
    isLoading,
    error,
    performSearch
  };
}