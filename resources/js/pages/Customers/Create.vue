<template>
    <div class="flex flex-col items-center p-10">
        <h1 class="py-5 font-bold text-2xl">Create new customer</h1>
        <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index" v-if="typeof errors === 'object'">
            <li>{{ value[0] }}</li>
        </ul>
        <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>
        <form method="post" @submit.prevent="handleCreate">
            <div class="mb-10">
                <label class="block text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-grey text-white" id="name"
                    type="text" v-model="form.name" required />
            </div>
            <div class="flex items-center justify-between">
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
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
            name: '',
        })
        const handleCreate = async () => {
            try {
                const result = await axios.post('/api/customers', form)
                if (result.status === 200)
                    await router.push({ name: 'customers' })
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
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