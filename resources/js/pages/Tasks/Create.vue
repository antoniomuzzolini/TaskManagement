<template>
    <div class="flex flex-col items-center p-10">
        <h1 class="py-5 font-bold text-2xl">Create new task</h1>
        <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index" v-if="typeof errors === 'object'">
            <li>{{ value[0] }}</li>
        </ul>
        <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>
        <form method="post" @submit.prevent="handleCreate">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="title">
                    Title *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-grey text-white" id="title"
                    type="text" v-model="form.title" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-grey text-white" id="description"
                    type="text" v-model="form.description" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="priority">
                    Priority
                </label>
                <select required id="priority" class="border text-white text-sm rounded-lg bg-grey block w-full p-2.5"
                    v-model="form.priority">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="project_id">
                    Project *
                </label>
                <select required id="project_id" class="border text-white text-sm rounded-lg bg-grey block w-full p-2.5"
                    v-model="form.project_id">
                    <option v-for="project in projects" :value="project.id">
                        {{ project.title }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="developer_id">
                    Developer
                </label>
                <select id="developer_id" class="border text-white text-sm rounded-lg bg-grey block w-full p-2.5"
                    v-model="form.developer_id">
                    <option v-for="developer in developers" :value="developer.id">
                        {{ developer.name }}
                    </option>
                </select>
            </div>
            <div class="flex items-center justify-between pt-10">
                <button class="bg-cyan-400 hover:bg-white hover:text-cyan-400 font-bold py-2 px-4 rounded" type="submit">
                    Create
                </button>
                <button class="bg-red-500 hover:bg-white hover:text-red-500 font-bold py-2 px-4 rounded" type="button"
                    @click="$router.go(-1)">&laquo;
                    Back
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
export default {
    data() {
        return {
            projects: [],
            developers: [],
        }
    },
    mounted() {
        axios
            .get('/api/projects', { params: { project_manager_id: localStorage.getItem('APP_USER_ID') } })
            .then(response => (this.projects = response.data))

        axios
            .get('/api/users/developer',)
            .then(response => (this.developers = response.data))

        if (this.$route.params.project_id !== undefined)
            this.form.project_id = this.$route.params.project_id
    },
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
            title: '',
            description: '',
            priority: 'medium',
            project_id: '',
            developer_id: '',
        })
        const handleCreate = async () => {
            try {
                const result = await axios.post('/api/tasks', form)
                if (result.status === 200)
                    await router.push({ name: 'project_tasks', params: { project_id: form.project_id } })
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = e.response.data.errors
                } else {
                    errors.value = e.response.data.message || ""
                }
            }
        }

        return {
            form,
            errors,
            handleCreate,
        }
    }
}
</script>