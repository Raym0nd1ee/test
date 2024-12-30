<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const isMenuOpen = ref(false);

const navItems = [
  { name: 'Home', path: '/' },
  { name: 'Jobs', path: '/jobs' },
  { name: 'Employers', path: '/employers' },
  { name: 'About', path: '/about' },
  { name: 'Contact', path: '/contact' }
];

const navigate = (path: string) => {
  router.push(path);
  isMenuOpen.value = false;
};
</script>

<template>
  <header class="bg-white shadow-md">
    <nav class="container mx-auto px-4 py-6">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h1 @click="navigate('/')" class="text-2xl font-bold text-primary cursor-pointer">Allied Jobs</h1>
        </div>
        
        <div class="hidden md:flex space-x-6">
          <a 
            v-for="item in navItems" 
            :key="item.path"
            @click="navigate(item.path)"
            class="text-gray-600 hover:text-primary cursor-pointer"
            :class="{ 'text-primary': $route.path === item.path }"
          >
            {{ item.name }}
          </a>
        </div>

        <button 
          class="md:hidden"
          @click="isMenuOpen = !isMenuOpen"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path 
              v-if="!isMenuOpen"
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M4 6h16M4 12h16M4 18h16"
            />
            <path 
              v-else
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>

      <!-- Mobile menu -->
      <div 
        v-if="isMenuOpen"
        class="md:hidden mt-4 space-y-2"
      >
        <a 
          v-for="item in navItems"
          :key="item.path"
          @click="navigate(item.path)"
          class="block text-gray-600 hover:text-primary py-2 cursor-pointer"
          :class="{ 'text-primary': $route.path === item.path }"
        >
          {{ item.name }}
        </a>
      </div>
    </nav>
  </header>
</template>