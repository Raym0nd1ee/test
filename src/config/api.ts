export const API_BASE_URL = import.meta.env.PROD 
  ? '/api' // Production API path
  : 'http://localhost/api'; // Development API path (adjust according to your PHP server setup)

  // Define API endpoints with correct casing
export const API_ENDPOINTS = {
  CONTACT: `${API_BASE_URL}/contact.php`,
  JOBS: `${API_BASE_URL}/jobs.php`,
  POST_JOB: `${API_BASE_URL}/post-job.php`,
  APPLY: `${API_BASE_URL}/apply.php`,
  RECRUITMENT: `${API_BASE_URL}/recruitment.php`
};