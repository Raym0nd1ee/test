import { ref } from 'vue';
import type { ContactForm } from '../types/contact';
import { submitContactForm } from '../services/contactService';
import { getErrorMessage } from '../utils/errorHandling';

export function useContactForm() {
  const isSubmitting = ref(false);
  const error = ref<string | null>(null);
  const success = ref<string | null>(null);

  const resetState = () => {
    error.value = null;
    success.value = null;
  };

  const submitForm = async (formData: ContactForm) => {
    try {
      isSubmitting.value = true;
      resetState();

      const response = await submitContactForm(formData);
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
    submitForm,
    resetState
  };
}