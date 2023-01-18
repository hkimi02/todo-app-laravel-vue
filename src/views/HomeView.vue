<template>
  
    <div class="container mt-5">
      
      <AddTask @search-task="searchTask"></AddTask>
      <categories :categories="categories_table"></categories>
      <div class="tasks row">
        <h3>tasks</h3>
        <div class="alert" :class="'alert-'+parametres.state" v-if="parametres!=null">
        {{ parametres.msg}} <i class='bi bi-x-lg float-end close-btn' @click="hideAlert"></i> 
        </div>
          <div v-if="tasks.data==null">
            <h1 class="title">you have no current tasks </h1>
            <router-link to="about" class="btn btn-primary">add new task</router-link>
          </div>
          <div v-else v-for="task in tasks.data" :key="task.id" class="col-lg-4">
            <HelloWorld :task="task" @refresh-subtasks="subtasks" @delete-task="Delete(task.id)" @update-task="Update" @update-parametres="updateParemetres"></HelloWorld>
          </div>
        </div>
        <div class="pagination">
        <Bootstrap5Pagination 
      :data="tasks"
      @pagination-change-page="subtasks"
      />
</div>
    </div>
  
</template>
<script setup>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
</script>
<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue';
import taskService from '@/services/taskService';
import AddTask from '@/components/AddTask.vue';
import categories from '@/components/categories.vue';



export default {
  name: 'HomeView',
  components: {
    HelloWorld,
    AddTask
},
  data(){
    return{
      tasks:{},
      categories_table:[],
      parametres:null,
    }
  },
  methods:{
    hideAlert(){
      this.parametres=null;
    },
    updateParemetres(newParemetres){
      this.parametres=newParemetres;
    },
    getCategories(){
      taskService.GetCategories().then(response=>{
        console.log(response.data);
        this.categories_table=response.data;
        console.table(this.categories_table);
      })
    },
    searchTask(search){
      console.log(search);
      taskService.searchTask(search).then(response=>{
          console.log(response.data);
          this.tasks=response.data;
      }).catch(error=>{
        console.log(error);
      })
    },
    subtasks(page = 1){
      taskService.getTaskswithsubtasks(page).then(response=>{
          this.tasks=response.data;
          console.table(response.data.data);
      })
    },
    Delete(id){
      console.log(id);
      taskService.deleteTask(id).then(response=>{
        this.parametres.msg=response.data;
        this.parametres.state='success';
        this.subtasks();
      });
    },
    fetchTasks(){
      taskService.getTasks().then(response=>{
        console.log(response.data);
        this.tasks=response.data;
      })
    },
    AddTask(task){
      taskService.createTask(task).then(response=>{
        alert("item created");
        this.subtasks();
      })
  },
  Update(id,newStatus){
    console.log(id);
    console.log(newStatus);
    taskService.updateTask(id,newStatus).then(response=>{
      this.subtasks();
    })
  }
  },
  created(){
    this.subtasks();
    this.getCategories();
    console.log(this.$route.query);
    this.parametres=this.$route.query;
  },
}
</script>
<style scoped>
.pagination{
  margin-top: 20px;
  justify-content: center;
}
</style>
