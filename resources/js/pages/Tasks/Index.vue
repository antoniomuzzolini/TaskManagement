<template>
    <h2 class="text-2xl text-center p-10">{{ customer ? 'Customer ' + customer.name : (project ? 'Project ' + project.title : 'All') }} tasks</h2>
    <table class="w-100 m-auto">
        <thead>
            <tr>
                <th class="p-5">title</th>
                <th class="p-5">description</th>
                <th class="p-5">priority</th>
                <th class="p-5">status</th>
                <th class="p-5">project</th>
                <th class="p-5">customer</th>
                <th class="p-5">developer</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(task,i) in tasks" :key="i" :class="{ 'text-cyan-400 font-bold': task.project.project_manager_id == this.user_id }">
                <td class="p-5">{{ task.title }}</td> 
                <td class="p-5">{{ task.description }}</td>  
                <td class="p-5">{{ task.priority }}</td> 
                <td class="p-5">
                    <select
                        id="status"
                        class="bg-grey text-cyan-400 text-sm rounded-lg block w-full p-2.5"
                        v-model="task.status"
                        v-if="task.developer_id == this.user_id && is('developer')"
                        @change="updateTaskStatus(task)">
                        <option value="backlog">backlog</option>
                        <option value="to do">to do</option>
                        <option value="in progress">in progress</option>
                        <option value="done">done</option>
                    </select>
                    <p v-else>{{ task.status }}</p>
                </td>
                <td class="p-5">{{ task.project.title }}</td>
                <td class="p-5">{{ task.project.customer.name }}</td>
                <td class="p-5">
                    <select
                        id="developer_id"
                        placeholder="(click to assign)"
                        class="bg-grey text-cyan-400 text-sm rounded-lg block w-full p-2.5"
                        v-model="task.developer_id"
                        v-if="task.project.project_manager_id == this.user_id && is('project manager')"
                        @change="updateTask(task)">
                        <option v-for="developer in developers" :value="developer.id">
                            {{ developer.name }}
                        </option>
                    </select>
                    <p v-else>{{ task.developer ? task.developer.name : '--' }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="flex w-100 justify-center pt-10">
        <router-link 
            v-if="can('create own project tasks')"
            :to="getLinkWithProjectId()"
            class="bg-cyan-400 hover:bg-white hover:text-cyan-400 font-bold py-2 px-4 rounded"
            >Create
        </router-link>
    </div>
</template>

<script>
    import { useToast } from "vue-toastification";
    
    export default {
        data () {
            return {
                tasks: null,
                project: null,
                customer: null,
                developers: [],
                user_id: localStorage.getItem('APP_USER_ID')
            }
        },
        mounted () {
            axios
                .get('/api/tasks', this.$route)
                .then(response => (this.tasks = response.data))
            if(this.$route.params.customer_id)
                axios
                    .get('/api/customers/'+this.$route.params.customer_id)
                    .then(response => (this.customer = response.data))
            if(this.$route.params.project_id)
                axios
                    .get('/api/projects/'+this.$route.params.project_id)
                    .then(response => (this.project = response.data))
                
            axios
                .get('/api/users/developer',)
                .then(response => (this.developers = response.data))
        },
        methods: {
            getLinkWithProjectId() {
                const route = {
                    name: 'task_create',
                };
                const projectId = this.$route.params.project_id;
                
                if (projectId !== undefined)
                    route.params = { project_id: projectId };
                
                return route;
            }
        },
        setup() {
            const toast = useToast();
            const updateTask = async (task) => {
                try {
                    const result = await axios.patch('/api/tasks/'+task.id, task)
                    if (result.status === 200 )
                        toast.success("Task assigned", {
                            timeout: 2000
                        });
                } catch (e) {
                    console.dir(e)
                }
            }
            const updateTaskStatus = async (task) => {
                try {
                    const result = await axios.patch('/api/tasks/'+task.id+'/status', task)
                    if (result.status === 200 )
                        toast.success("Task status changed", {
                            timeout: 2000
                        });
                } catch (e) {
                    console.dir(e)
                }
            }
            return {
                updateTask,
                updateTaskStatus,
                toast
            }
        }
    }
</script>