import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import JobsView from '../views/JobsView.vue';
import EmployersView from '../views/EmployersView.vue';
import AboutView from '../views/AboutView.vue';
import ContactView from '../views/ContactView.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/jobs',
      name: 'jobs',
      component: JobsView
    },
    {
      path: '/employers',
      name: 'employers',
      component: EmployersView
    },
    {
      path: '/about',
      name: 'about',
      component: AboutView
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactView
    }
  ]
});

export default router;