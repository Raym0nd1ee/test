<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
    <textarea
      v-if="type === 'textarea'"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
      :rows="rows"
      :required="required"
      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
    ></textarea>
    <input
      v-else
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      :required="required"
      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
    />
  </div>
</template>

<script setup lang="ts">
defineProps<{
  modelValue: string;
  label: string;
  type?: 'text' | 'email' | 'textarea';
  required?: boolean;
  rows?: number;
}>();

defineEmits<{
  (e: 'update:modelValue', value: string): void;
}>();
</script>