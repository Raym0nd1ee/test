<template>
  <button
    type="submit"
    :disabled="isSubmitting"
    class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-primary/90 transition-colors disabled:opacity-50"
  >
    {{ isSubmitting ? submittingText : submitText }}
  </button>
</template>

<script setup lang="ts">
defineProps<{
  isSubmitting: boolean;
  submitText: string;
  submittingText: string;
}>();
</script>