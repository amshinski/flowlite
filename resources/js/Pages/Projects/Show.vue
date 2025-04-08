<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    project: Object,
    availableUsers: Array,
});

const editMode = ref(false);
const showTeamForm = ref(false);

const form = useForm({
    name: props.project.name,
    description: props.project.description,
});

const teamForm = useForm({
    name: '',
    project_id: props.project.id
});

const updateProject = () => {
    form.put(route('projects.update', props.project.id), {
        preserveScroll: true,
        onSuccess: () => {
            editMode.value = false;
            router.reload();
        }
    });
};

const createTeam = () => {
    teamForm.post(route('projects.teams.store', { project: props.project.id }), {
        preserveScroll: true,
        onSuccess: () => {
            showTeamForm.value = false;
            teamForm.reset();
        }
    });
};
</script>

<template>
    <AppLayout title="Project">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-8">
                        <div class="min-h-screen py-8 backdrop-blur-sm
                        bg-gray-800/40 border border-white/10 rounded-2xl p-6 hover:border-indigo-300/30
                        transition-all duration-300 shadow-2xl shadow-black/30">

                            <div class="flex justify-between items-start">
                                <div class="w-96">
                                    <h1 class="text-2xl font-bold text-gray-200">
                                        <TextInput
                                            v-if="editMode"
                                            v-model="form.name"
                                            placeholder="Name"
                                            :errors="form.errors.name" />
                                        <span v-else>{{ project.name }}</span>
                                    </h1>
                                    <InputError v-if="editMode" :message="form.errors.name" class="mt-2" />
                                    <p class="text-gray-400 mt-2 pb-2">
                                        <TextArea
                                            v-if="editMode"
                                            v-model="form.description"
                                            placeholder="Description"
                                            class="w-96"
                                            :errors="form.errors.description">
                                        </TextArea>
                                        <span v-else>{{ project.description || 'No description' }}</span>
                                    </p>
                                    <InputError v-if="editMode" :message="form.errors.description" class="mt-2" />
                                </div>
                                <div class="space-x-4">
                                    <PrimaryButton
                                        v-if="!editMode"
                                        @click="editMode = true">
                                        Edit Project
                                    </PrimaryButton>
                                    <div v-else class="space-x-2">
                                        <PrimaryButton @click="updateProject" :disabled="form.processing">
                                            Save Changes
                                        </PrimaryButton>
                                        <DangerButton @click="editMode = false">
                                            Cancel
                                        </DangerButton>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-700 pt-6 pb-2">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-200">Project Teams</h2>
                                    <PrimaryButton v-if="!showTeamForm" @click="showTeamForm = !showTeamForm">
                                        Add Team
                                    </PrimaryButton>
                                </div>

                                <!-- Add Team Form -->
                                <div v-if="showTeamForm" class="mb-6 bg-gray-800/30 p-4 rounded-xl backdrop-blur-sm">
                                    <form @submit.prevent="createTeam" class="space-y-4">
                                        <div>
                                            <TextInput
                                                v-model="teamForm.name"
                                                placeholder="Team name"
                                                :errors="teamForm.errors.name" />
                                            <InputError :message="teamForm.errors.name" class="mt-2" />
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <DangerButton @click="showTeamForm = false">
                                                Cancel
                                            </DangerButton>
                                            <PrimaryButton type="submit" :disabled="teamForm.processing">
                                                Create Team
                                            </PrimaryButton>
                                        </div>
                                    </form>
                                </div>

                                <!-- Teams List -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <a
                                        v-for="team in project.teams"
                                        :key="team.id"
                                        :href="route('projects.teams.show', { project: project.id, team: team.id })"
                                        class="bg-gray-700/50 hover:bg-gray-600/60 rounded-lg p-4
                                            transition-colors backdrop-blur-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-200 font-medium">{{ team.name }}</span>
                                            <span class="text-sm bg-gray-800/40 text-gray-400 px-2 py-1 rounded-full">
                                                {{ team.members_count }} members
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <p v-if="project.teams.length === 0" class="text-gray-400 mt-4">
                                    No teams created yet.
                                </p>
                            </div>

                            <div class="border-t border-gray-700 pt-6">
                                <h2 class="text-xl font-semibold text-gray-200 mb-4">Available Users</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div
                                        v-for="user in availableUsers"
                                        :key="user.id"
                                        class="bg-gray-700/50 rounded-lg p-4">
                                        <div class="flex items-center space-x-3">
                                            <img
                                                :src="user.profile_photo_url"
                                                :alt="user.name"
                                                class="h-8 w-8 rounded-full bg-gray-100">
                                            <span class="text-gray-200">{{ user.name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p v-if="availableUsers.length === 0" class="text-gray-400">
                                    No available users outside current teams.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
