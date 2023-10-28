<template>
    <div :class="[task.completed_at ? 'border-l-[5px] border-green-400' : '', 'w-full bg-white text-gray-900 shadow-md rounded-[5px] p-3 pb-8 mb-4 relative']"
        @mouseenter="kanban.hoveredName = task.name" 
        @mouseleave="kanban.unhoverTask()"
        @click="kanban.selectTask(task)">
        <div class="flex justify-between mb-1">
            <p class="mt-2">{{ task.name }}</p>
            <PencilSquareIcon v-if="props.showEdit" class="w-5 h-5 absolute top-1 right-1 hover:cursor-pointer text-gray-500"
                @click.stop="updateTaskProps(task)" />
        </div>

        <div class="text-xs text-gray-500 absolute bottom-2 ">{{ task.user.name }}</div>
        <img class="w-8 h-8 shadow-lg rounded-full absolute bottom-0 right-0 mr-1 mb-1 border-2 border-white"
            :src="getAvatar()" :alt="task.user.name" />
    </div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban';
import { sha256 } from 'js-sha256';
import { PencilSquareIcon } from '@heroicons/vue/20/solid';
const kanban = useKanbanStore()

const getAvatar = function () {
    if (props.task.user.profile_picture_url !== null) {
        return props.task.user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(props.task.user.email).trim().toLowerCase()) + "?size=40");
    }
}

const props = defineProps({
    task: {
        type: Object,
        required: true
    },
    showEdit: {
        type: Boolean,
        required: true
    }
})

const updateTaskProps = (task) => {
    kanban.updatingTask = true
    kanban.updatingTaskProps = Object.assign({}, kanban.updatingTaskProps, task)
}
</script>