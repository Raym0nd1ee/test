<!-- src/components/ContactForm.vue -->
<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <FormAlert v-if="error" type="error" :message="error" />
    <FormAlert v-if="success" type="success" :message="success" />

    <FormField
      v-model="form.name"
      label="Name"
      type="text"
      required
    />

    <FormField
      v-model="form.email"
      label="Email"
      type="email"
      required
    />

    <FormField
      v-model="form.subject"
      label="Subject"
      type="text"
      required
    />

    <FormField
      v-model="form.message"
      label="Message"
      type="textarea"
      :rows="4"
      required
    />

    <SubmitButton
      :is-submitting="isSubmitting"
      submit-text="Send Message"
      submitting-text="Sending..."
    />
  </form>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { useContactForm } from '../composables/useContactForm';
import FormField from './form/FormField.vue';
import FormAlert from './form/FormAlert.vue';
import SubmitButton from './form/SubmitButton.vue';

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
});

const { isSubmitting, error, success, submitForm } = useContactForm();

const resetForm = () => {
  form.name = '';
  form.email = '';
  form.subject = '';
  form.message = '';
};

const handleSubmit = async () => {
  const result = await submitForm(form);
  if (result) {
    resetForm();
  }
};
</script>