<template>
    <div class="container mt-5">
        <div class="form shadow-lg">
            <h3>edit new task</h3>
            <form method="post" @submit.prevent="UpdateTask">
                <div class="mb-3">
                    <label for="task_name" class="form-label">task name</label>
                    <input type="text" class="form-control" id="task_name" v-model="name">
                    <p class="text-danger">{{ nameError }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">due date</label>
                    <input type="datetime" class="form-control" id="exampleInputPassword1" v-model="duedate">
                    <p class="text-danger">{{ errorDuedate }}</p>
                </div>
                <div class="form-check" v-for="category, index in categories_table">
                    <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                        :checked="added_categories.indexOf(category.id) != -1" @click="check_category(category.id)">
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
    props: ["id"],
    data() {
        return {
            name: '',
            duedate: null,
            task: null,
            categories_table: [],
            errorDuedate: '',
            nameError: '',
            added_categories: [],
        }
    },
    methods: {
        check_category(id) {
            for (let i = 0; i < this.added_categories.length; i++) {
                if (this.added_categories[i] == id) {
                    this.added_categories.splice(i, 1);
                    console.log(this.added_categories);
                    return;
                }
            }
            console.log(this.added_categories);
            this.added_categories[this.added_categories.length] = id;
            console.log(this.added_categories);
        },
        getCategories() {
            taskService.GetCategories().then(response => {
                console.log(response.data);
                this.categories_table = response.data;
                console.log(this.categories_table);
            })
        },
        UpdateTask() {
            if(this.name==''){
                this.nameError='name feild cant be empty';
                return ;
            }
            if(this.duedate==''){
                this.errorDuedate='due date field cant be empty'
                return ;
            }
            let date = new Date(this.duedate);
            let isoDate = date.toISOString().slice(0, 10);
            console.log(isoDate);
            let task = {
                name: this.name,
                duedate: isoDate,
            }
            taskService.updateTaskInfo(this.id, task).then(response => {
                console.log(response.data);
                for(let i=0;i<this.task.category.length;i++){
                    console.log(this.task.category[i]);
                    taskService.destroyRelation(this.task.category[i].id,this.task.id).then(thirdresponse => {
                        console.log(thirdresponse.data);
                    })
                }
                for (let i = 0; i < this.added_categories.length; i++) {
                    if(this.added_categories[i]){
                    let newaddcategory = {
                        task_id: this.task.id,
                        category_id: this.added_categories[i]
                    }
                    taskService.createrelation(newaddcategory).then(secondResponse => {
                        console.log(secondResponse.data);
                    })
                }
            }
                this.$router.push('/?msg=task updated succesfully&state=success');
            }).catch(error=>{
                    console.log(error);
            });
        }
    },
    created() {
        console.log(this.id);
        taskService.getTaskWithId(this.id).then(response => {
            this.task = response.data[0];
            for(let i=0;i<this.task.category.length;i++){
                this.added_categories.push(this.task.category[i].id);
            }
            console.log(this.added_categories);
            this.name = response.data[0].name;
            this.duedate = (new Date(response.data[0].duedate)).toLocaleDateString();
        })
        this.getCategories();
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