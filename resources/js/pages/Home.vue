<template>
    <div class="overflow-x-auto w-screen md:overflow-x-none">
        <div class="grid grid-cols-3 p-5 min-w-max md:min-w-0">
            <div class="w-80 md:w-auto">
                <h2 class="text-2xl text-left text-cyan-400 text-center">TO DO</h2>
                <TaskCard v-for="(task, key) in tasks.filter(obj => obj.status == 'to do')" :task="task" :user_id="user_id"
                    :developers="developers" />
            </div>
            <div class="w-80 md:w-auto">
                <h2 class="text-2xl text-left text-cyan-400 text-center">IN PROGRESS</h2>
                <TaskCard v-for="(task, key) in tasks.filter(obj => obj.status == 'in progress')" :task="task"
                    :user_id="user_id" :developers="developers" />
            </div>
            <div class="w-80 md:w-auto">
                <h2 class="text-2xl text-left text-cyan-400 text-center">DONE</h2>
                <TaskCard v-for="(task, key) in tasks.filter(obj => obj.status == 'done')" :task="task" :user_id="user_id"
                    :developers="developers" />
            </div>
        </div>
    </div>
    <div class="flex w-100 justify-center pt-10">
        <router-link v-if="can('create own project tasks')" :to="{ name: 'task_create' }"
            class="bg-cyan-400 hover:bg-white hover:text-cyan-400 font-bold py-2 px-4 rounded">Create
        </router-link>
    </div>
</template>

<script>
import TaskCard from '../components/Task.vue'
import { useToast } from "vue-toastification"

export default {
    components: {
        TaskCard
    },
    data() {
        return {
            tasks: [],
            user_id: localStorage.getItem('APP_USER_ID'),
            developers: []
        }
    },
    mounted() {
        axios
            .get('/api/tasks', { params: { homepage: true } })
            .then((response) => {
                this.tasks = response.data
            })
        axios
            .get('/api/users/developer',)
            .then(response => (this.developers = response.data))
    },
    methods: {
        updateTaskStatus(task) {
            axios
                .patch('/api/tasks/' + task.id + '/status', task)
                .then((response) => {
                    useToast().success("Task status changed", {
                        timeout: 2000
                    });
                })
                .catch((errors) => {
                    useToast().error("An error occurred", {
                        timeout: 2000
                    });
                });
        },
        updateTask(task) {
            axios
                .patch('/api/tasks/' + task.id, task)
                .then((response) => {
                    useToast().success("Task assigned", {
                        timeout: 2000
                    });
                })
                .catch((errors) => {
                    useToast().error("An error occurred", {
                        timeout: 2000
                    });
                });
        },
    }
}
</script>