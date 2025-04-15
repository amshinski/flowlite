<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = ref({
    name: '',
    description: '',
});

const projects = ref(usePage().props.projects || []);

const createProject = () => {
    router.post(route('projects.store'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            form.value = { name: '', description: '' };
            router.reload({ only: ['projects'] });
        }
    });
};

const visitTeamPage = (projectId, teamId) => {
    router.get(route('projects.teams.show', {
        project: projectId,
        team: teamId
    }));
};
</script>

<template>
    <div class="min-h-screen py-8 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Project Cards -->
                <div
                    v-for="project in projects"
                    :key="project.id"
                    class="glass-dark p-6">
                    <div class="flex justify-between items-start mb-4 gap-4">
                        <a :href="route('projects.show', { project: project.id })" class="flex-1 min-w-0">
                            <h3 class="text-xl font-semibold text-primary truncate">
                                {{ project.name }}
                            </h3>
                        </a>
                        <div class="flex-shrink-0">
                            <span class="text-sm bg-white/5 text-secondary px-3 py-1 rounded-full backdrop-blur-sm">
                                {{ project.teams_count }}
                            </span>
                        </div>
                    </div>

                    <p class="text-secondary mb-6 text-sm" v-if="project.description">
                        {{ project.description }}
                    </p>

                    <!-- Teams List -->
                    <div v-if="project.teams.length > 0" class="border-t border-white/10 pt-4">
                        <h4 class="text-sm font-semibold text-secondary mb-3">
                            Teams
                        </h4>
                        <ul class="space-y-3">
                            <li
                                v-for="team in project.teams"
                                :key="team.id"
                                @click.prevent="visitTeamPage(project.id, team.id)"
                                class="group flex items-center justify-between bg-white/5 hover:bg-white/10 p-3
                                    rounded-xl transition-all duration-200 cursor-pointer backdrop-blur-sm">
                                <span class="text-primary text-sm font-medium truncate">
                                    {{ team.name }}
                                </span>
                                <span class="text-xs bg-white/5 text-secondary px-2.5 py-1 rounded-full">
                                    {{ team.members_count }} {{ team.members_count === 1 ? 'member' : 'members' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="projects.length === 0"
                    class="col-span-full text-center py-12 border-2 border-dashed border-white/10 rounded-2xl
                        bg-gray-900/30 backdrop-blur-lg">
                    <div class="text-primary mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0
                                    012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0
                                    012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-primary font-medium">No projects found</p>
                </div>
            </div>

            <!-- Create Project Card -->
            <div
                class="bg-gray-800/30 border border-white/10 rounded-2xl p-6 shadow-2xl shadow-black/30
                    backdrop-blur-lg">
                <h2 class="text-2xl font-bold mb-4 text-primary">
                    New Project
                </h2>
                <form @submit.prevent="createProject">
                    <div class="mb-6">
                        <label class="block text-secondary text-sm font-semibold mb-3">
                            Project Name
                        </label>
                        <TextInput
                            v-model="form.name"
                            placeholder="Project name"
                            :errors="$page.props.errors.name" />
                        <p v-if="$page.props.errors.name" class="text-red-400/80 text-sm mt-2">
                            {{ $page.props.errors.name }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-secondary text-sm font-semibold mb-3">
                            Description
                        </label>
                        <TextArea
                            v-model="form.description"
                            placeholder="Description"
                            :errors="$page.props.errors.description">
                        </TextArea>
                        <p v-if="$page.props.errors.description" class="text-red-400/80 text-sm mt-2">
                            {{ $page.props.errors.description }}
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton type="submit" class="h-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Create Project</span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
