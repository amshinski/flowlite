<!-- Popover.vue -->
<script setup>
import { ref } from 'vue';

const isHovered = ref(false);
</script>

<template>
    <div class="relative inline-block">
        <div
            @mouseover="isHovered = true"
            @mouseleave="isHovered = false"
            class="cursor-pointer">
            <slot name="trigger"></slot>
        </div>

        <div
            v-show="isHovered"
            class="glass-dark absolute z-50 left-0 top-full
                mt-2 px-2 w-max text-gray-200 overflow-hidden origin-bottom-right"
            :class="isHovered ? 'opacity-100' : 'opacity-0'">
            <div class="py-1">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>
