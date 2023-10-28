<template>
<div class="w-[300px] bg-gray-200 rounded-lg shadow-lg">
    <div class="flex flex-col justify-between p-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base text-gray-500 font-medium mb-4">
                {{ kanban.phases[props.phase_id].name }} {{ kanban.phases[props.phase_id].tasks_count }}</h2>
            <div class="flex text-gray-500">
                <PlusIcon
                    v-if="!kanban.phases[props.phase_id].completed"
                    @click="createTask()"
                    v-tippy="{ content: 'Create a new task' }"
                    class="mb-3 h-6 w-6 hover:cursor-pointer"
                    aria-hidden="true" />
                <TrashIcon
                    @click="clickTrashIcon(props.phase_id)"
                    v-tippy="{ content: 'Remove the phase'}"
                    class="mb-3 h-6 w-6 mr-1 hover:cursor-pointer"
                    aria-hidden="true" />
                <StarIcon
                    v-if="!kanban.phases[props.phase_id].completed"
                    @click="clickStarIcon(props.phase_id)"
                    v-tippy="{ content: 'Mark as completed'}"
                    class="mb-3 h-6 w-6 mr-1 hover:cursor-pointer"
                    aria-hidden="true" />
                <StarSolidIcon
                    v-else
                    @click="clickStarIcon(props.phase_id)"
                    v-tippy="{ content: 'Mark as incompleted'}"
                    class="mb-3 h-6 w-6 mr-1 hover:cursor-pointer"
                    aria-hidden="true" />
            </div>
        </div>
        <div class="max-h-[calc(100vh-240px)] scrollbar-hide overflow-y-auto">
            <task-card v-if="kanban.phases[props.phase_id].tasks.length > 0" v-for="task in kanban.phases[props.phase_id].tasks" :task="task" :showEdit="true" />

            <!-- A card to create a new task -->
            <div v-if="!kanban.phases[props.phase_id].completed" 
                class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-2 relative"
                @click="createTask()">
                <span>Create a new task</span>
                <PlusIcon class="h-6 w-6" aria-hidden="true" />
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, StarIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { StarIcon as StarSolidIcon } from '@heroicons/vue/24/solid'

const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

const clickTrashIcon = (id) => {
    kanban.openModal = true;
    kanban.phaseInAction = id;
}

const clickStarIcon = (id) => {
    kanban.openModal = true;
    kanban.markingPhase = true;
    kanban.phaseInAction = id;
}
</script>
