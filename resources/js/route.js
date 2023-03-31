import {createRouter, createWebHistory} from 'vue-router';

const CustomersIndex = () => import('./pages/Customers/Index.vue')
const CustomersCreate = () => import('./pages/Customers/Create.vue')

const ProjectsIndex = () => import('./pages/Projects/Index.vue')
const ProjectsCreate = () => import('./pages/Projects/Create.vue')

const TasksIndex = () => import('./pages/Tasks/Index.vue')
const TasksCreate = () => import('./pages/Tasks/Create.vue')

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/home',
            name: 'home',
            component: () => import('./pages/Home.vue')
        },
        {
            path: '/customers',
            children: [
                {
                    path: '',
                    name: 'customers',
                    component: CustomersIndex
                },
                {
                    path: 'create',
                    name: 'customer_create',
                    component: CustomersCreate
                },
                {
                    path: ':customer_id/projects',
                    name: 'customer_projects',
                    component: ProjectsIndex
                },
                {
                    path: ':customer_id/tasks',
                    name: 'customer_tasks',
                    component: TasksIndex
                },
            ]
        },
        {
            path: '/projects',
            children: [
                {
                    path: '',
                    name: 'projects',
                    component: ProjectsIndex
                },
                {
                    path: 'create/:customer_id?',
                    name: 'project_create',
                    component: ProjectsCreate
                },
                {
                    path: ':project_id/tasks',
                    name: 'project_tasks',
                    component: TasksIndex
                },
            ]
        },
        {
            path: '/tasks',
            children: [
                {
                    path: '',
                    name: 'tasks',
                    component: TasksIndex
                },
                {
                    path: 'create/:project_id?',
                    name: 'task_create',
                    component: TasksCreate
                },
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./pages/Login.vue')
        }
    ],
})

router.beforeEach((to, from, next) => {
    if(to.name == 'login')
        next();
    else
        axios.get('/api/user')
            .then(response => {
                if(response.data)
                {
                    if(to.name == 'login')
                    {
                        next({name: 'home'});
                    }
                    else
                    {
                        next();
                    }
                }
                else
                {
                    next({name: 'login'});
                }
            })
            .catch(error => {
                next({name: 'login'});
            });
});

export default router;