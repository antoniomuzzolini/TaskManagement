# TaskManagement

tabelle
user by laravel
role by spatie
permission by spatie

customer
    id
    name

project
    id
    title
    description
    customer_id
    project_manager_id

task
    id
    title
    description
    priority (int?enum? high-medium-low)
    status (enum backlog - to do - in progress - done)
    project_id
    developer_id
