import type { Job } from '../types/Job';

export const mockJobs: Job[] = [
  {
    id: 1,
    title: 'Senior Software Engineer',
    company: 'Tech Solutions Inc.',
    location: 'Auckland, NZ',
    type: 'Full-time',
    description: 'We are looking for a Senior Software Engineer to join our growing team...',
    salary: '$120,000 - $150,000',
    posted_date: '2024-02-20'
  },
  {
    id: 2,
    title: 'Product Manager',
    company: 'Innovation Labs',
    location: 'Wellington, NZ',
    type: 'Full-time',
    description: 'Exciting opportunity for an experienced Product Manager to lead our product development...',
    salary: '$100,000 - $130,000',
    posted_date: '2024-02-19'
  },
  {
    id: 3,
    title: 'Frontend Developer',
    company: 'Digital Creatives',
    location: 'Christchurch, NZ',
    type: 'Full-time',
    description: 'Join our creative team as a Frontend Developer...',
    salary: '$80,000 - $100,000',
    posted_date: '2024-02-18'
  }
];