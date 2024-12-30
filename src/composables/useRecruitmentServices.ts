import { ref } from 'vue';
import type { RecruitmentRequest } from '../types/RecruitmentRequest';
import { submitRecruitmentRequest } from '../services/recruitmentService';
import { getErrorMessage } from '../utils/errorHandling';

export function useRecruitmentServices() {
  const isSubmitting = ref(false);
  const error = ref<string | null>(null);
  const success = ref<string | null>(null);

  const submitRequest = async (recruitmentData: RecruitmentRequest) => {
    try {
      isSubmitting.value = true;
      error.value = null;
      success.value = null;

      const response = await submitRecruitmentRequest(recruitmentData);
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
    submitRequest
  };
}