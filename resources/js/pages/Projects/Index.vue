<template>
    <h2 class="text-2xl text-center p-10">{{ customer ? 'Customer ' + customer.name : 'All' }} projects</h2>
    <table class="w-100 m-auto">
        <thead>
            <tr>
                <th class="p-5">title</th>
                <th class="p-5">description</th>
                <th class="p-5">customer</th>
                <th class="p-5">project manager</th>
                <th class="p-5">tasks</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(project,i) in projects" :key="i" :class="{ 'text-cyan-400 font-bold': project.project_manager_id == this.user_id }">
                <td class="p-5">{{ project.title }}</td> 
                <td class="p-5">{{ project.description }}</td>  
                <td class="p-5">{{ project.customer.name }}</td>
                <td class="p-5">{{ project.project_manager.name }}</td>
                <td class="p-5">
                    <router-link
                        :to="{ name: 'project_tasks', params: { project_id: project.id } }"
                        class="text-sm hover:text-cyan-400 cursor-pointer"
                        :class="{ 'hover:text-white': project.project_manager_id == this.user_id }"
                        >{{ project.tasks_count }} (open)
                    </router-link>
                </td>  
            </tr>
        </tbody>
    </table>
    <div class="flex w-100 justify-center pt-10">
        <router-link 
            v-if="can('create projects')"
            :to="getLinkWithCustomerId()"
            class="bg-cyan-400 hover:bg-white hover:text-cyan-400 font-bold py-2 px-4 rounded"
            >Create
        </router-link>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                projects: null,
                customer: null,
                user_id: localStorage.getItem('APP_USER_ID')
            }
        },
        mounted () {
            axios
                .get('/api/projects', this.$route)
                .then(response => (this.projects = response.data))
            if(this.$route.params.customer_id)
                axios
                    .get('/api/customers/'+this.$route.params.customer_id)
                    .then(response => (this.customer = response.data))
        },
        methods: {
            getLinkWithCustomerId() {
                const route = {
                    name: 'project_create',
                };
                const customerId = this.$route.params.customer_id;
                
                if (customerId !== undefined)
                    route.params = { customer_id: customerId };
                
                return route;
            },
        },
        setup() {
        }
    }
</script>