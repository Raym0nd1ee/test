<template>
  <div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Contact Us</h1>
    
    <div class="grid md:grid-cols-2 gap-8">
      <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold text-primary mb-6">Get in Touch</h2>
        <ContactForm />
      </div>

      <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold text-primary mb-6">Contact Information</h2>
        <ContactInfo />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import ContactForm from '../components/ContactForm.vue';
import ContactInfo from '../components/ContactInfo.vue';
</script>