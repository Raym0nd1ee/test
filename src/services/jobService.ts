import type { Job } from '../types/Job';
import { apiClient, handleApiError } from '../utils/apiUtils';
import { APIError } from '../utils/errorHandling';

export const validateJobData = (data: unknown): data is Job[] => {
  if (!Array.isArray(data)) {
    return false;
  }
  return data.every(item => (
    typeof item === 'object' &&
    item !== null &&
    'id' in item &&
    'title' in item &&
    'company' in item &&
    'location' in item &&
    'type' in item &&
    'description' in item &&
    'salary' in item &&
    'posted_date' in item
  ));
};

export const searchJobs = async (keyword: string, location: string): Promise<Job[]> => {
  try {
    const response = await apiClient.get('/jobs.php', {
      params: { 
        keyword: keyword.trim(),
        location: location.trim()
      }
    });

    if (!validateJobData(response.data)) {
      throw new APIError('Invalid data format received from server');
    }

    return response.data.map(job => ({
      id: Number(job.id),
      title: String(job.title),
      company: String(job.company),
      location: String(job.location),
      type: String(job.type),
      description: String(job.description),
      salary: String(job.salary),
      posted_date: String(job.posted_date)
    }));
  } catch (error) {
    handleApiError(error);
    throw error; // Re-throw to be handled by the composable
  }
};