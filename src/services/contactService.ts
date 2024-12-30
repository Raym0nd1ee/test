import axios, { AxiosError } from 'axios';
import type { ContactForm, ContactResponse } from '../types/contact';
import { API_ENDPOINTS} from '../config/api';
import { validateContactForm } from '../utils/validation';
import { APIError } from '../utils/errorHandling';

export const submitContactForm = async (formData: ContactForm): Promise<ContactResponse> => {
  try {
    validateContactForm(formData);

    const response = await axios.post<ContactResponse>(
      API_ENDPOINTS.CONTACT,
      formData,
      {
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Headers':'*'
        }
      }
    );
    
    if (!response.data.success) {
      throw new APIError(response.data.message || 'Failed to submit form');
    }

    return response.data;
  } catch (error) {
    if (error instanceof APIError) {
      throw error;
    }
    if (axios.isAxiosError(error)) {
      const axiosError = error as AxiosError<ContactResponse>;
      throw new APIError(
        axiosError.response?.data?.message || 'Network error occurred',
        axiosError.response?.status
      );
    }
    throw new APIError('An unexpected error occurred');
  }
};