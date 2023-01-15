<template>
    <div class="container mt-5">
        <div class="form shadow-lg">
            <h3>edit new task</h3>
            <form method="post" @submit.prevent="UpdateTask">
                <div class="mb-3">
                    <label for="task_name" class="form-label">task name</label>
                    <input type="text" class="form-control" id="task_name" v-model="name">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">due date</label>
                    <input type="datetime" class="form-control" id="exampleInputPassword1" v-model="duedate">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>
<script>
import taskService from '@/services/taskService';

export default {
    props: ["id"],
    data() {
        return {
            name: '',
            duedate: null,
            task: null,
            categories_table: [],
        }
    },
    methods: {
        splitAddedCategories() {
            console.log(this.categories_table);
            for (let i = 0; i < this.categories_table.length; i++) {
                for (let j = 0; j < this.task.category.length; j++) {
                    console.log(this.task.category[j].pivot.categories_id);
                    console.log(this.categories_table[i].id);
                    if (this.categories_table[i].id == this.task.category[j].pivot.categories_id) {
                        this.categories_table.splice(i, 1);
                    }
                }
            }
        },
        getCategories() {
            taskService.GetCategories().then(response => {
                console.log(response.data);
                this.categories_table = response.data;
                console.log(this.categories_table);
            })
        },
        UpdateTask() {
            let date = new Date(this.duedate);
            let isoDate = date.toISOString().slice(0, 10);
            console.log(isoDate);
            let task = {
                name: this.name,
                duedate: isoDate,
            }
            taskService.updateTaskInfo(this.id, task).then(response => {
                console.log(response.data);
                this.$router.push('/');
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created() {
        console.log(this.id);
        taskService.getTaskWithId(this.id).then(response => {
            this.task = response.data[0];
            console.log(this.task);
            this.name = response.data[0].name;
            this.duedate = (new Date(response.data[0].duedate)).toLocaleDateString();
        })
        this.getCategories();
        //this.splitAddedCategories();
    }
}
</script>
<style scoped>
.form {
    height: 25rem;
    width: 20rem;
    margin-top: 10%;
    padding: 5%;
    justify-content: center;
    text-align: center;
}

.container {
    display: grid;
    justify-content: center !important;
}
</style>