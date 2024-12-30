import axios from 'axios';
import type { JobPost, JobPostResponse } from '../types/JobPost';
import { API_BASE_URL } from '../config/api';
import { APIError } from '../utils/errorHandling';
import { validateJobPost } from '../utils/jobValidation';

export const submitJobPost = async (jobData: JobPost): Promise<JobPostResponse> => {
  try {
    validateJobPost(jobData);

    const response = await axios.post<JobPostResponse>(
      `${API_BASE_URL}/post-job.php`,
      jobData,
      {
        headers: {
          'Content-Type': 'application/json',
        }
      }
    );

    if (!response.data.success) {
      throw new APIError(response.data.message || 'Failed to post job');
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
    throw new APIError('Failed to post job');
  }
};