export interface JobApplication {
  jobId: number;
  fullName: string;
  email: string;
  phone: string;
  resume: File | null;
  coverLetter: string;
}

export interface ApplicationResponse {
  success: boolean;
  message: string;
}