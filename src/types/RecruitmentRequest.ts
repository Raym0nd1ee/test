export interface RecruitmentRequest {
    companyName: string;
    contactPerson: string;
    email: string;
    phone: string;
    service: string;
    message: string;
    status: string;
  }
  export interface RecruitmentResponse {
    success: boolean;
    message: string;
    jobId?: number;
    companyName: string;
    contactPerson: string;
    email: string;
    phone: string;
    service: string;   
    status: string;
  }