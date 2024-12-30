<template>
  <div
    :class="[
      'px-4 py-3 rounded',
      type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' : 'bg-green-100 border border-green-400 text-green-700'
    ]"
  >
    {{ message }}
  </div>
</template>

<script setup lang="ts">
defineProps<{
  type: 'error' | 'success';
  message: string;
}>();
</script>