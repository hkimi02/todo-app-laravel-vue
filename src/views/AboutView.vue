<template>
    <div class="container">
        <div class="form shadow-lg">
            <h3>add new task</h3>
            <form method="post" @submit.prevent="addTask">
                <div class="mb-3">
                    <label for="task_name" class="form-label">task name</label>
                    <input type="text" class="form-control" id="task_name" v-model="name">
                    <p class="text-danger">{{ nameError }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">due date</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" :min="min_date"
                        v-model="duedate">
                    <p class="text-danger">{{ errorDuedate }}</p>
                </div>
                <h4 class="text-center">categories</h4>
                <div class="form-check" v-for="category, index in categories">
                    <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                        @click="check_category(category.id)">
                    <label class="form-check-label" for="flexCheckDefault">{{ category.name }}
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>
<script>
import taskService from '@/services/taskService';
export default {
    data() {
        return {
            min_date: null,
            name: '',
            duedate: null,
            categories: [],
            checked_categories: [],
            nameError: '',
            errorDuedate: '',
        }
    },
    methods: {
        check_category(id) {
            for (let i = 0; i < this.checked_categories.length; i++) {
                if (this.checked_categories[i] == id) {
                    this.checked_categories.splice(i, 1);
                    return;
                }
            }
            this.checked_categories[this.checked_categories.length] = id;
        },
        getCategories() {
            taskService.GetCategories().then(response => {
                console.log(response.data);
                this.categories = response.data;
            })
        },
        addTask() {
            let task = {
                name: this.name,
                duedate: this.duedate,
            }
            taskService.createTask(task).then(response => {
                console.log(response.data);
                for (let i = 0; i < this.checked_categories.length; i++) {
                    let newaddcategory = {
                        task_id: response.data.id,
                        category_id: this.checked_categories[i]
                    }
                    taskService.createrelation(newaddcategory).then(secondResponse => {
                        console.log(secondResponse.data);
                    })
                }
                this.$router.push('/?msg=task created succesfully&state=success');
            }).catch(error => {
                console.log(error.response.data.errors);
                this.nameError = error.response.data.errors.name[0];
                this.errorDuedate = error.response.data.errors.duedate[0];
            })
        }
    },
    created() {
        this.min_date = new Date;
        this.getCategories();
    },
}
</script>
<style scoped>
.form {
    height: 30rem;
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