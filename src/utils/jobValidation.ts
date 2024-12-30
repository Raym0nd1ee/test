import { ValidationError } from './errorHandling';
import type { JobPost } from '../types/JobPost';

export const validateJobPost = (data: JobPost): void => {
  const requiredFields: (keyof JobPost)[] = [
    'title',
    'company',
    'location',
    'type',
    'description',
    'salary'
  ];

  const missingFields = requiredFields.filter(field => !data[field]);
  
  if (missingFields.length > 0) {
    throw new ValidationError(`Missing required fields: ${missingFields.join(', ')}`);
  }

  if (data.description.length < 50) {
    throw new ValidationError('Job description must be at least 50 characters long');
  }
};