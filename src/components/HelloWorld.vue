<template>
  <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" :id="'task'+task.id">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{edit ? 'update subtask' : 'add new subtask'}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" :id="'close'+task.id" id=""></button>
      </div>
      <div class="modal-body">
        <form method="post" @submit.prevent="edit ? updateInfoSubtask() :  addSubTask(task.id) ">
                <div class="mb-3">
                    <label for="descrip" class="form-label">description</label>
                    <input type="text" class="form-control" id="descrip" v-model="subTaskDescription">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">due date</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" 
                        v-model="deadline">
                </div>
                <button type="submit" class="btn btn-primary">{{edit ? 'update' :  'submit'}}</button>
            </form>
      </div>
    </div>
  </div>
</div>
        <div class="">
        <div class="card card-margin">
            <div class="card-header no-border">
              <div class="categories">
                <span class="badge text-bg-primary" v-for="categorie in task.category">{{categorie.name}}</span>
              </div>
                <h5 :class="[task.subtasks?.every(s=>{return s.status}) ? 'btn-success' : 'btn-danger']" class="btn state"><i class="bi bi-calendar-check"></i></h5>
            </div>
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-primary">
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title">{{ task.name }}</span>
                            <span class="widget-49-meeting-time">{{task.created_at}}</span>
                        </div>
                    </div>
                    <ol class="widget-49-meeting-points subtasks-list">
                      <li class="widget-49-meeting-item" :class="[subtask.status ? 'badge text-bg-success' :'badge text-bg-danger' ]" v-for="subtask in task.subtasks"><span>{{subtask.description}}</span><span>{{ subtask.deadline }}</span> <span class="btn check-subtask" @click="makeDone(subtask.id)"> <i class="bi bi-check2-all"></i></span><button class="btn col" @click="DeleteSubTask(subtask.id)"><i class="bi bi-trash3"></i></button><button class="btn col" data-bs-toggle="modal" :data-bs-target="'#task'+task.id" @click="editsubtask(subtask.id)"><i class="bi bi-pen"></i></button></li>
                    </ol> 
                    <div class="widget-49-meeting-action">
                      <a href="#" class="btn btn-sm btn-flash-border-primary"><button class="btn btn-primary  col" data-bs-toggle="modal" :data-bs-target="'#task'+task.id"><i class="bi bi-plus-circle"></i></button></a>
                        <router-link :to="{name:'edittask',params:{id:task.id}}" class="btn btn-sm btn-flash-border-primary"><button class="btn btn-warning bg-warning col"><i class="bi bi-pen"></i></button></router-link>
                        <a href="#" class="btn btn-sm btn-flash-border-primary"><button class="btn btn-danger bg-danger col" @click="Delete"><i class="bi bi-trash3"></i></button></a>
                      </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import taskService from '@/services/taskService';
import categories from './categories.vue'; 

export default {
  name: 'HelloWorld',
  emits:['delete-task','update-task','refresh-subtasks'],
  props: {
    task: Object
  },
  data(){
    return{
      subtasks:[],
      subTaskDescription:'',
      deadline:null,
      edit:false,
      selectedSubtask:null,
    }
  },
  methods:{
    updateInfoSubtask(){
      let subtask={
        description:this.subTaskDescription,
        deadline:this.deadline,
      }
      taskService.UpdateSubtask(this.selectedSubtask, subtask).then(response=>{
        alert('updated succesfully ');
        this.subTaskDescription='';
        this.deadline=null;
        this.edit=false;
        this.selectedSubtask=null;
        this.$emit('refresh-subtasks');
        document.querySelector("#close"+this.task.id).click();
      })
    },
    editsubtask(id){
      console.log(id);
      console.log(this.task.subtasks.length);
        for(let i=0;i<this.task.subtasks.length;i++){
              if(this.task.subtasks[i].id==id){
                  this.subTaskDescription=this.task.subtasks[i].description;
                  this.deadline=this.task.subtasks[i].deadline;
                  this.edit=true;
                  this.selectedSubtask=id;
                  return ;
              } 
        }
    },
    DeleteSubTask(id){
      if(confirm('do you really want to delet this subtask')){
      taskService.DeleteSubTask(id).then(response=>{
        this.$emit('refresh-subtasks');
        alert("subtask deleted");
        })
      }
    },
    Delete(){
      if(confirm('do you really wanna delete this item')){
        this.$emit('delete-task');
      }  
    },
    makeDone(id){
      taskService.makeDone(id).then(response=>{
        this.$emit('refresh-subtasks');
        alert("subtask updated");
      })
    },
    Update(state){
      let newStatus={
        done: state,
      }
      console.log('hany nabaath');
        this.$emit('update-task',this.task.id,newStatus);
    },
    addSubTask(id_task){
      console.log(this.task.id);
        let subtask={
          description:this.subTaskDescription,
          deadline:this.deadline,
        }
        console.log(this.task.id);
        taskService.createSubTask(subtask,this.task.id).then(response=>{
        this.$emit('refresh-subtasks');
        this.taskDone();
        alert("subtask created");
        document.querySelector("#close"+this.task.id).click();
        })
    },
    get_id(){
      console.log(this.task.id);
    },
    taskDone(){
      console.log('hnay dkhalet hnee');
      if(this.task.subtasks.length==0){
        this.Update(true);
        this.$emit('refresh-subtasks');
        return;
      }
      else{
          for(let i=0;i<this.task.subtasks.length;i++){
            if(this.task.subtasks[i].status==false){
              this.Update(false);
              this.$emit('refresh-subtasks');
              return ;
            }
          }
      }
      this.Update(true);
      this.$emit('refresh-subtasks');
    }
  },
  created(){
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.check-subtask{
  height: 20px!important;
  width: 30px!important;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.card-margin {
    margin-bottom: 1.875rem;
}
.state{
  margin-left: 80%;
}
.card {
    border: 0;
    box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #ffffff;
    background-clip: border-box;
    border: 1px solid #e6e4e9;
    border-radius: 8px;
}

.card .card-header.no-border {
    border: 0;
}
.card .card-header {
    background: none;
    padding: 0 0.9375rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    min-height: 50px;
}
.card-header:first-child {
    border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
}

.widget-49 .widget-49-title-wrapper {
  display: flex;
  align-items: center;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #edf1fc;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
  color: #4e73e5;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
  color: #4e73e5;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #fcfcfd;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
  color: #dde1e9;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
  color: #dde1e9;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #e8faf8;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
  color: #17d1bd;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
  color: #17d1bd;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #ebf7ff;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
  color: #36afff;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
  color: #36afff;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: floralwhite;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
  color: #FFC868;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
  color: #FFC868;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #feeeef;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
  color: #F95062;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
  color: #F95062;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #fefeff;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
  color: #f7f9fa;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
  color: #f7f9fa;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #ebedee;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
  color: #394856;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
  color: #394856;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #f0fafb;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
  color: #68CBD7;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
  color: #68CBD7;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
  display: flex;
  flex-direction: column;
  margin-left: 1rem;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
  color: #3c4142;
  font-size: 14px;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
  color: #B1BAC5;
  font-size: 13px;
}

.widget-49 .widget-49-meeting-points {
  font-weight: 400;
  font-size: 13px;
  margin-top: .5rem;
}

.widget-49 .widget-49-meeting-points .widget-49-meeting-item {
  display: list-item;
  color: #727686;
}

.widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
  margin-left: .5rem;
}

.widget-49 .widget-49-meeting-action {
  text-align: right;
}

.widget-49 .widget-49-meeting-action a {
  text-transform: uppercase;
}
.subtasks-list{
  display: grid!important;
  grid-template-rows: 1fr!important;
  grid: 10px!important;
}
</style>
