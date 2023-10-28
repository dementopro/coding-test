import { defineStore } from 'pinia'

export const useKanbanStore = defineStore('kanban', {
  state: () => {
    return { 
        hoveredName: 'nothing',
        selectedTask: null,
        phases: [],
        users: [],
        creatingTask: false,
        creatingTaskProps: {
          name: '',
          phase_id: null,
          user_id: null,
        },
        updatingTask: false,
        updatingTaskProps: {
          name: '',
          phase_id: null,
          user_id: null,
        },
        submittingTask: false,
        boardLoading: false,
        self: null,
        openModal: false,
        confirmingAction: false,
        markingPhase: false,
        phaseInAction: null,
        userTasks: [],
        completedTasksThisWeek: [],
        completedTasksThisMonth: [],
        pageLoaded: false,
    }
  },
  actions: {
    unhoverTask() {
      this.hoveredName = 'nothing'
    },
    selectTask(task) {
        this.selectedTask = task
    },
    unselectTask(task) {
        this.selectedTask = null
    },
    hasSelectedTask() {
        return this.selectedTask !== null
    },
  },
})