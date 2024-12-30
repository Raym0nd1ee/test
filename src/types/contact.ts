
export interface ContactForm {
    name: string;
    email: string;
    subject: string;
    message: string;
    [key: string]: string;  
  }
  
  export interface ContactResponse {
    success: boolean;
    name: string;
    email: string;
    subject: string;
    message: string;
  }