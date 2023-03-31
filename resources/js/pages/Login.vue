<!--Login.vue-->
<template>
    <div class="flex flex-col items-center p-10">
        <h1 class="text-white py-5 font-bold text-3xl"> Login </h1>
        <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index" v-if="typeof errors === 'object'">
            <li>{{value[0]}}</li>
        </ul>
        <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{errors}}</p>
        <form method="post" @submit.prevent="handleLogin">
        <div class="mb-4">
            <label
                class="block text-grey-darker text-sm font-bold mb-2"
                for="username"
            >
                Email Address
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-white bg-grey"
                id="username"
                type="text"
                v-model="form.email"
                required
            />
        </div>
        <div class="mb-4">
            <label
                class="block text-grey-darker text-sm font-bold mb-2"
                for="password"
            >
                Password
            </label>
            <input
                class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-white bg-grey mb-3"
                id="password"
                type="password"
                v-model="form.password"
                required
            />
        </div>
        <div class="flex items-center justify-center">
            <button
                class="bg-cyan-400 hover:bg-white hover:text-cyan-400 font-bold py-2 px-4 rounded"
                type="submit"
            >
                Sign In
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
                email: '',
                password: '',
            })
            const handleLogin = async () => {
                try {
                    const result = await axios.post('/api/login', form)
                    if (result.status === 200 && result.data && result.data.token) {
                        localStorage.setItem('APP_USER_TOKEN', result.data.token)
                        const user = await axios.get('/api/user')
                        if (user.status === 200) {
                            localStorage.setItem('APP_USER_NAME', user.data.name)
                            localStorage.setItem('APP_USER_ID', user.data.id)
                            window.location.pathname = '/home';
                            // await router.push('home')
                        }
                    }
                } catch (e) {
                    if(e && e.response.data && e.response.data.errors) {
                        errors.value = Object.values(e.response.data.errors)
                    } else {
                        errors.value = e.response.data.message || ""
                    }
                }
            }

            return {
                form,
                errors,
                handleLogin,
            }
        }
    }
</script>