<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    errors: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        :class="{ '!border-red-400/60': errors }"
        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:ring-2 focus:ring-indigo-400/50
            focus:border-transparent text-gray-200 placeholder-gray-400/60 transition-all backdrop-blur-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
