export interface JobPost {
    title: string;
    company: string;
    location: string;
    type: string;
    description: string;
    salary: string;
  }
  
  export interface JobPostResponse {
    success: boolean;
    message: string;
    jobId?: number;
  }