import { ref } from 'vue';
import type { JobPost } from '../types/JobPost';
import { submitJobPost } from '../services/jobPostService';
import { getErrorMessage } from '../utils/errorHandling';

export function useJobPost() {
  const isSubmitting = ref(false);
  const error = ref<string | null>(null);
  const success = ref<string | null>(null);

  const resetState = () => {
    error.value = null;
    success.value = null;
  };

  const postJob = async (jobData: JobPost) => {
    try {
      isSubmitting.value = true;
      resetState();

      const response = await submitJobPost(jobData);
      success.value = response.message;
      return true;
    } catch (e) {
      error.value = getErrorMessage(e);
      return false;
    } finally {
      isSubmitting.value = false;
    }
  };

  return {
    isSubmitting,
    error,
    success,
    postJob,
    resetState
  };
}