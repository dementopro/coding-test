<template>
    <div class="max-w-7xl flex-1 mx-auto flex flex-col overflow-auto sm:px-6 lg:px-8 pt-6">
        <div id="statistic-container" ref="statisticContainer" class="flex-1 flex overflow-auto scrollbar-hide shadow-lg">
            <div class="text-gray-900">
                <div class="h-full flex overflow-x-auto overflow-y-auto space-x-4">
                    <div class="w-[300px] bg-gray-200 rounded-lg shadow-lg max-h-[calc(100vh-165px)] scrollbar-hide overflow-y-auto">
                        <div class="flex flex-col justify-between p-4" ref="taskContainer">
                            <div class="flex items-center justify-between mb-4 h-8">
                                <Listbox as="div" v-model="selectedUser" class="w-full">
                                    <div class="relative">
                                        <ListboxButton
                                            class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm sm:leading-6">
                                            <div v-if="selectedUser !== null">
                                                <span class="flex items-center">
                                                    <img :src="getAvatar(kanban.users[selectedUser || kanban.self.id])" 
                                                        alt="" 
                                                        class="h-5 w-5 flex-shrink-0 rounded-full" 
                                                    />
                                                    <span class="ml-3 block truncate">{{ kanban.users[selectedUser || kanban.self.id].name }}</span>
                                                </span>
                                                <span
                                                    class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                                    <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                                </span>
                                            </div>
                                            <div v-else>
                                                <span>Select User...</span>
                                            </div>
                                        </ListboxButton>

                                        <transition leave-active-class="transition ease-in duration-100"
                                            leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <ListboxOptions
                                                class="absolute z-20 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                <ListboxOption as="template" :key="0" :value="null" v-slot="{ active, selected }">
                                                    <li :class="[active ? 'bg-blue-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <div class="flex items-center">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">Select User ...</span>
                                                        </div>

                                                        <span v-if="selected"
                                                            :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                        </span>
                                                    </li>
                                                </ListboxOption>
                                                <ListboxOption as="template" v-for="person in kanban.users" :key="person.id"
                                                    :value="person.id" v-slot="{ active, selected }">
                                                    <li :class="[active ? 'bg-blue-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <div class="flex items-center">
                                                            <img :src="getAvatar(person)" alt="{{ person.name }}"
                                                                class="h-5 w-5 flex-shrink-0 rounded-full" />
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">{{ person.name }}</span>
                                                        </div>

                                                        <span v-if="selected"
                                                            :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                        </span>
                                                    </li>
                                                </ListboxOption>
                                            </ListboxOptions>
                                        </transition>
                                    </div>
                                </Listbox>
                            </div>
                            <div class="max-h-[calc(100vh-245px)] scrollbar-hide overflow-y-auto">
                                <task-card v-if="kanban.userTasks.length > 0" v-for="task in kanban.userTasks" :task="task" :showEdit="false" />
                            </div>
                        </div>
                    </div>
                    <div class="w-[300px] bg-gray-200 rounded-lg shadow-lg max-h-[calc(100vh-165px)] scrollbar-hide overflow-y-auto">
                        <div class="flex flex-col justify-between p-4">
                            <div class="flex items-center justify-between mb-4 h-8">
                                <h2 class="text-base text-gray-500 font-medium">
                                    Completed this week</h2>
                            </div>
                            <div class="max-h-[calc(100vh-245px)] scrollbar-hide overflow-y-auto">
                                <task-card v-if="kanban.completedTasksThisWeek.length > 0" v-for="task in kanban.completedTasksThisWeek" :task="task" :showEdit="false" />
                            </div>
                        </div>
                    </div>
                    <div class="w-[300px] bg-gray-200 rounded-lg shadow-lg max-h-[calc(100vh-165px)] scrollbar-hide overflow-y-auto">
                        <div class="flex flex-col justify-between p-4">
                            <div class="flex items-center justify-between mb-4 h-8">
                                <h2 class="text-base text-gray-500 font-medium">
                                    Completed this month</h2>
                            </div>
                            <div class="max-h-[calc(100vh-245px)] scrollbar-hide overflow-y-auto">
                                <task-card v-if="kanban.completedTasksThisMonth.length > 0" v-for="task in kanban.completedTasksThisMonth" :task="task" :showEdit="false" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick, watch } from 'vue'
import { useKanbanStore } from '../stores/kanban'
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import { useLoading } from 'vue-loading-overlay'
import { sha256 } from 'js-sha256';
import axios from 'axios'


const kanban = useKanbanStore()
const errors = ref(null)
const selectedUser = ref(null)
watch(selectedUser, (newUser, oldUser) => {
    getUserTasks(newUser);
})

const $loading = useLoading()

const getAvatar = function (user) {
    if (user.profile_picture_url !== null) {
        return user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(user.email).trim().toLowerCase()) + "?size=400");
    }
}

const refreshTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        const originalTasks = response.data;
        kanban.phases = originalTasks.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}

const refreshUsers = async () => {
    try {
        const response = await axios.get('/api/users');
        const originalUsers = response.data;
        // rekey originalUsers to use the id property in the objects as the array key
        kanban.users = originalUsers.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the users!', error);
    }
}

const getSelf = async () => {
    try {
        const response = await axios.get('/api/user');
        kanban.self = response.data;
        if (kanban.creatingTaskProps.user_id === null) {
            kanban.creatingTaskProps.user_id = kanban.self.id;
        }
        if (kanban.self.profile_picture_url === null) {
            kanban.self.profile_picture_url = getAvatar(kanban.self)
        }
    } catch (error) {
        console.error('There was an error fetching the logged in user!', error);
    }
}

const getUserTasks = async (user_id) => {
    try {
        const loader = $loading.show({
            backgroundColor: "#4B4B4B",
            color: "#FFF",
            opacity: 0.5
        });
        const response = await axios.get(`/api/tasks/user/${user_id}`);
        loader.hide();
        kanban.userTasks = response.data;
    } catch (error) {
        console.log(error);
    }
}

const getCompletedTasksThisWeek = async () => {
    try {
        const response = await axios.get('/api/tasks/week');
        kanban.completedTasksThisWeek = response.data;
    } catch (error) {
        console.log(error);
    }
}

const getCompletedTasksThisMonth = async () => {
    try {
        const response = await axios.get('/api/tasks/month');
        kanban.completedTasksThisMonth = response.data;
    } catch (error) {
        console.log(error);
    }
}

onMounted(async () => {
    const loader = $loading.show({
        backgroundColor: "#4B4B4B",
        color: "#FFF",
        opacity: 0.5
    });
    await refreshTasks();
    await refreshUsers();
    await getSelf();
    await getCompletedTasksThisWeek();
    await getCompletedTasksThisMonth();

    loader.hide();

    await nextTick();
})
</script>

<style scoped>/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}</style>