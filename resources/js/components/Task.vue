<template>
    <div class="rounded border-cyan-400 border m-1 p-2 grid grid-cols-2 place-content-between">
        <p class="text-lg w-fit h-fit">
            {{ task.title }}
        </p>
        <p class="uppercase justify-self-end w-fit h-fit" :class="{
            'text-red-500': task.priority == 'high',
            'text-orange-500': task.priority == 'medium',
        }">
            {{ task.priority }}
        </p>
        <p class="text-xs w-fit h-fit self-end">
            {{ task.project.title }}
        </p>
        <div>
            <select v-if="can('update status own tasks') && user_id == task.developer_id"
                class="bg-grey text-white text-sm rounded-lg block w-full p-2.5 text-right" v-model="task.status"
                @change="updateTaskStatus(task)">
                <option value="to do">to do</option>
                <option value="in progress">in progress</option>
                <option value="done">done</option>
            </select>
            <select v-else-if="can('update own project tasks') && user_id == task.project.project_manager_id"
                class="bg-grey text-white text-sm rounded-lg block w-full p-2.5 text-right" placeholder="(click to assign)"
                v-model="task.developer_id" @change="updateTask(task)">
                <option v-for="developer in developers" :value="developer.id">
                    {{ developer.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'task',
        'user_id',
        'developers',
        'task'
    ],
    methods: {
        updateTaskStatus(task) {
            this.$parent.updateTaskStatus(task);
        },
        updateTask(task) {
            this.$parent.updateTask(task);
        },
    }
}
</script>
