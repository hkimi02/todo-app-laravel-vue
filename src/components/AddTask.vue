<template>
    <div class="form">
        <form  method="post" @submit.prevent="searchTask">
            <div class="row grid gap-3">
        <div class="input-group mb-3 col-6">
        <input type="text" class="form-control" placeholder="search tasks" aria-label="Username" aria-describedby="basic-addon1" v-model="taskName" @input.prevent="searchTask">
        <button type="submit" value='' class="col-0 btn btn-primary"><i class="bi bi-search"></i></button>
    </div>
</div>
</form>
</div>
</template>
<script>
export default{
    emits:['search-task'],
    data(){
        return{
            taskName:'',
        }
    },
    methods:{
        searchTask(){
            console.log(this.taskName);
            this.$emit('search-task',this.taskName);
        }
    }
}
</script>
<style scoped>
</style>