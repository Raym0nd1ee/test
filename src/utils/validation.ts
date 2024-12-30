export const validateContactForm = (data: Record<string, unknown>): void => {
  const requiredFields = ['name', 'email', 'subject', 'message'];
  const missingFields = requiredFields.filter(field => !data[field]);
  
  if (missingFields.length > 0) {
    throw new Error(`Missing required fields: ${missingFields.join(', ')}`);
  }

  // Email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(data.email as string)) {
    throw new Error('Invalid email format');
  }
};