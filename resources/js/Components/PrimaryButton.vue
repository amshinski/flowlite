<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 font-semibold text-xs text-white uppercase
        tracking-widest disabled:opacity-50 backdrop-blur-sm
        bg-gray-800/40 border border-white/10 rounded-2xl p-6 hover:border-indigo-300/30
        transition-all duration-300 shadow-2xl shadow-black/30">
        <slot />
    </button>
</template>
