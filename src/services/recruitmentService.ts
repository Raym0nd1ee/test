import axios from 'axios';
import type { RecruitmentRequest, RecruitmentResponse } from '../types/RecruitmentRequest';
import { API_BASE_URL } from '../config/api';
import { APIError } from '../utils/errorHandling';

export const submitRecruitmentRequest = async (recuitmentData: RecruitmentRequest) : Promise<RecruitmentResponse> => {
  try {
    const response = await axios.post<RecruitmentResponse>(
      `${API_BASE_URL}/recuitment.php/`,
      recuitmentData,
      {
        headers: {
          'Content-Type': 'application/json',
        }
      }
    );

    if (!response.data.success) {
      throw new APIError(response.data.message || 'Failed to submit request');
    }

    return response.data;
  } catch (error) {
    if (error instanceof APIError) {
      throw error;
    }
    if (axios.isAxiosError(error)) {
      const message = error.response?.data?.message || 'Network error occurred';
      throw new APIError(message, error.response?.status);
    }
    throw new APIError('Failed to submit request');
  }
};