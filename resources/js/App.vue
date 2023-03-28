<template>
    <div
        class="bg-white shadow-lg rounded-lg m-auto flex flex-col"
    >
    <div class="bg-gray-100">
      <nav
        class="container px-6 py-8 w-screen md:flex md:justify-between md:items-center"
        v-if="!['login'].includes($route.name)"
      >
        <div class="flex items-center justify-between">
          <router-link
            :to="{ name: 'home' }"
            class=" text-xl font-bold text-gray-800 md:text-2xl hover:text-blue-400"
            >Task Management
          </router-link>
          <!-- Mobile menu button -->
          <div @click="showMenu = !showMenu" class="flex md:hidden">
            <button
              type="button"
              class=" text-gray-800 hover:text-gray-400 focus:outline-none focus:text-gray-400"
            >
              <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                <path
                  fill-rule="evenodd"
                  d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
                ></path>
              </svg>
            </button>
          </div>
        </div>


        <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
        <ul
          :class="showMenu ? 'flex' : 'hidden'"
          class=" flex-col mt-8 space-y-4 md:flex md:space-y-0 md:flex-row md:items-center md:space-x-10 md:mt-0"
        >
            <router-link
                :to="{ name: 'customers' }"
                class="text-sm font-bold text-gray-800 hover:text-blue-400"
                >All customers
            </router-link>
            <router-link
                :to="{ name: 'projects' }"
                class="text-sm font-bold text-gray-800 hover:text-blue-400"
                >All projects
            </router-link>
            <router-link
                :to="{ name: 'tasks' }"
                class="text-sm font-bold text-gray-800 hover:text-blue-400"
                >All tasks
            </router-link>
            <li class="text-sm font-bold text-gray-800 hover:text-red-400 cursor-pointer" @click="handleLogout">
                {{ this.user_name }}, Logout
            </li>
          <!-- <router-link
            to="/logout"
            class="text-sm font-bold text-gray-800 hover:text-blue-400"
            >Logout
          </router-link> -->
        </ul>
      </nav>
    </div>
    <div class="pb-10">
        <router-view :key="$route.path"></router-view>
    </div>
  </div>

</template>

<script>
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    export default {
        data() {
          return {
            user_name: localStorage.getItem('APP_USER_NAME')
          }
        },
        setup() {
            let showMenu = ref(false);
            const errors = ref()
            const router = useRouter();
            const handleLogout = async () => {
                try {
                    const result = await axios.post('/api/logout', null)
                    if (result.status === 200) {
                        localStorage.removeItem('APP_USER_TOKEN')
                        await router.push('login')
                    }
                } catch (e) {
                    if(e && e.response && e.response.errors) {
                        errors.value = Object.values(e.response.errors)
                    } else {
                        console.dir(e)
                        errors.value = e.response.message || ""
                    }
                }
            }
            
            return {
                showMenu,
                errors,
                handleLogout,
            }
        }
    }
</script>