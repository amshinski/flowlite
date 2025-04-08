<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Home from '@/Components/Home.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <Home />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
