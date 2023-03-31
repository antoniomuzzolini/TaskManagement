<template>
    <table class="w-100 m-auto">
        <thead>
            <tr>
                <th class="p-5">name</th>
                <th class="p-5">projects</th>
                <th class="p-5">tasks</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(customer, i) in customers" :key="i">
                <td class="p-5">{{ customer.name }}</td>
                <td class="p-5">
                    <router-link :to="{ name: 'customer_projects', params: { customer_id: customer.id } }"
                        class="text-sm hover:text-cyan-400 cursor-pointer">{{ customer.projects_count }} (open)
                    </router-link>
                </td>
                <td class="p-5">
                    <router-link :to="{ name: 'customer_tasks', params: { customer_id: customer.id } }"
                        class="text-sm hover:text-cyan-400 cursor-pointer">{{ customer.tasks_count }} (open)
                    </router-link>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="flex w-100 justify-center pt-10">
        <router-link v-if="can('create customers')" :to="{ name: 'customer_create' }"
            class="bg-cyan-400 hover:bg-white hover:text-cyan-400 font-bold py-2 px-4 rounded">Create
        </router-link>
    </div>
</template>

<script>
export default {
    data() {
        return {
            customers: null
        }
    },
    mounted() {
        axios
            .get('/api/customers')
            .then(response => (this.customers = response.data))
    },
    setup() {
    }
}
</script>