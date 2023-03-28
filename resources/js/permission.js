import { abilitiesPlugin } from '@casl/vue'

async function fetchUserPermissions() {
    const response = await axios.get('/api/user/permissions')
    return response.data.permissions
}
