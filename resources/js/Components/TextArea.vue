<script setup>
defineProps({
    modelValue: String,
    errors: String,
});

defineEmits(['update:modelValue']);
</script>

<template>
    <textarea
        :value="modelValue"
        :class="{ '!border-red-400/60': errors }"
        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:ring-2 focus:ring-indigo-400/50
            focus:border-transparent text-gray-200 placeholder-gray-400/60 h-32 transition-all backdrop-blur-sm"
        rows="3"
        @input="$emit('update:modelValue', $event.target.value)">
    </textarea>
</template>
