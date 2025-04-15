<script setup>
import Popover from '@/Components/Popover.vue';

const props = defineProps({
    status: {
        required: false,
        type: String,
    },
});
</script>

<template>
    <div>
        <img v-if="!status" src="../../images/logo.svg" class="size-16" :class="$attrs.class" alt="flowlite"/>
        <Popover>
            <template #trigger>
                <img
                    v-if="status && status === 'planned'"
                    src="../../images/svg/blueprint.svg"
                    class="size-16"
                    :class="$attrs.class"
                    alt="flowlite"/>
            </template>
            <template #content>
                Planned Tasks
            </template>
        </Popover>
        <Popover>
            <template #trigger>
                <img
                    v-if="status && status === 'in_work'"
                    src="../../images/svg/wrench.svg"
                    class="size-16"
                    :class="$attrs.class"
                    alt="flowlite" />
            </template>
            <template #content>
                In-Work
            </template>
        </Popover>
        <Popover>
            <template #trigger>
                <img
                    v-if="status && status === 'testing'"
                    src="../../images/svg/microscope.svg"
                    class="size-16"
                    :class="$attrs.class"
                    alt="flowlite"/>
            </template>
            <template #content>
                Testing
            </template>
        </Popover>
        <Popover>
            <template #trigger>
                <img
                    v-if="status && status === 'finished'"
                    src="../../images/svg/approve.svg"
                    class="size-16"
                    :class="$attrs.class"
                    alt="flowlite"/>
            </template>
            <template #content>
                Finished Tasks
            </template>
        </Popover>
    </div>
</template>
