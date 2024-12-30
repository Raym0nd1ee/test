import axios, { AxiosError } from 'axios';
import { APIError } from './errorHandling';
import { API_BASE_URL } from '../config/api';

export const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

export const handleApiError = (error: unknown) => {
  if (axios.isAxiosError(error)) {
    const axiosError = error as AxiosError;
    if (axiosError.response) {
      throw new APIError(
        axiosError.response.data?.message || 'Server error',
        axiosError.response.status
      );
    } else if (axiosError.request) {
      throw new APIError('No response from server. Please check your connection.');
    }
  }
  throw new APIError('Failed to process request');
};