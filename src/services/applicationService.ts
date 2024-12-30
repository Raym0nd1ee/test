import axios from 'axios';
import type { JobApplication, ApplicationResponse } from '../types/Application';
import { API_BASE_URL } from '../config/api';

export const submitApplication = async (application: JobApplication): Promise<ApplicationResponse> => {
  try {
    const formData = new FormData();
    formData.append('jobId', application.jobId.toString());
    formData.append('fullName', application.fullName);
    formData.append('email', application.email);
    formData.append('phone', application.phone);
    formData.append('coverLetter', application.coverLetter);
    
    if (application.resume) {
      formData.append('resume', application.resume);
    }

    const response = await axios.post(`${API_BASE_URL}/apply.php`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    return response.data;
  } catch (error) {
    console.error('Error submitting application:', error);
    throw new Error('Failed to submit application');
  }
};