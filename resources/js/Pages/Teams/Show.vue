<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import TextArea from '@/Components/TextArea.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    project: Object,
    team: Object,
    tasks: Object,
    status: String,
    statuses: Object,
});

const showCreateForm = ref(false);

const taskForm = useForm({
    name: '',
    title: '',
    description: '',
    priority: 'low',
});

const createTask = () => {
    taskForm.post(route('tasks.store', { project: props.project.id, team: props.team.id }), {
        onSuccess: () => {
            showCreateForm.value = false;
            taskForm.reset();
        }
    });
};
</script>

<template>
    <AppLayout
        :title="team.name"
        :hasDashboard="false"
        :statuses="statuses"
        :project="project"
        :team="team"
        :status="status">
        <div class="py-2 px-4 flex flex-row justify-between">
            <div class="inline-flex items-center">
                <a :href="route('dashboard')">
                    <PrimaryButton class="rounded-r-none text-primary">
                        <img src="../../../images/svg/home.svg" class="size-4" alt="Dashboard" />
                    </PrimaryButton>
                </a>
                <a :href="route('projects.show', { project: project.id })">
                    <PrimaryButton class="rounded-none text-primary">
                        {{ project.name }}
                    </PrimaryButton>
                </a>
                <PrimaryButton class="rounded-l-none text-primary pointer-events-none">
                    {{ team.name }}
                </PrimaryButton>
            </div>
            <PrimaryButton @click="showCreateForm = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </PrimaryButton>
        </div>

        <Modal :show="showCreateForm" @close="showCreateForm = false">
            <div class="p-6">
                <form @submit.prevent="createTask" class="space-y-4">
                    <TextInput
                        v-model="taskForm.name"
                        placeholder="Name (A-Za-z0-9-/.)"
                        :errors="taskForm.errors.name" />
                    <InputError :message="taskForm.errors.name" />

                    <TextInput
                        v-model="taskForm.title"
                        placeholder="Title"
                        :errors="taskForm.errors.title" />
                    <InputError :message="taskForm.errors.title" />

                    <TextArea
                        v-model="taskForm.description"
                        placeholder="Description"
                        :errors="taskForm.errors.description">
                    </TextArea>
                    <InputError :message="taskForm.errors.description" />

                    <select
                        v-model="taskForm.priority"
                        class="w-full px-4 py-3 bg-white/5 border rounded-xl block border-white/10
                            placeholder-gray-400 text-primary focus:ring-2 focus:ring-indigo-400/50
                            focus:border-transparent">
                        <option
                            style="background-color: #111827"
                            value="low">
                            Low Priority
                        </option>
                        <option
                            style="background-color: #111827"
                            value="medium">
                            Medium Priority
                        </option>
                        <option
                            style="background-color: #111827"
                            value="high">
                            High Priority
                        </option>
                    </select>

                    <div class="flex justify-end space-x-3">
                        <DangerButton @click="showCreateForm = false">Cancel</DangerButton>
                        <PrimaryButton type="submit" :disabled="!taskForm.title || !taskForm.description">
                            Create Task
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <div class="grid grid-cols-1 2xs:grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6
            xl:grid-cols-7 2xl:grid-cols-8 gap-3 mt-2 mx-4">
            <div
                v-for="task in tasks"
                class="glass-dark py-3 px-4 overflow-hidden">
                <div class="flex flex-col">
                    <div class="text-primary mb-1.5">
                        {{ task.name }}
                    </div>
                    <div class="border-t border-white/10 break-words text-sm text-secondary pt-2">
                        {{ task.title }}
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
