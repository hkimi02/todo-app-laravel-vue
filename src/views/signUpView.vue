<template>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3>Sign Up</h3>
                            <div class="alert alert-success" v-if="message!=''">
                                {{ message }}<i class='bi bi-x-lg float-end close-btn' @click="hideAlert"></i> 
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="signUp">
                                <div class="form-group">
                                    <label for="name" class="float-start">Name</label>
                                    <input type="text" class="form-control" id="name" v-model="name">
                                    <p class="text-danger" v-if="nameError">{{ nameError[0] }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="float-start">Email</label>
                                    <input type="email" class="form-control" id="email" v-model="email">
                                    <p class="text-danger" v-if="emailError">{{ emailError[0] }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="float-start">Password</label>
                                    <input type="password" class="form-control" id="password" v-model="password">
                                    <p class="text-danger" v-if="passwordError">{{ passwordError[0] }}</p>
                                </div>
                                <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <h3>you have an account <router-link to="/">Log in</router-link></h3>
        </div>
</template>
<script>
import taskService from '@/services/taskService'

export default{

    data(){
        return{
            name:'',
            email:'',
            password:'',
            nameError:'',
            emailError:'',
            passwordError:'',
            message:''
        }
    },
    methods:{
        hideAlert(){
            this.message='';
        },
        signUp(){
            this.nameError='';
            this.emailError='';
            this.passwordError='';
            let newUser={
                name:this.name,
                email:this.email,
                password:this.password
            }
            taskService.signUpUser(newUser).then(response=>{
                this.message=response.data;
                this.name='';
                this.email='';
                this.password='';
            }).catch(error=>{
                console.log(error);
                this.nameError=typeof(error.response.data.errors.name)!=undefined ? error.response.data.errors.name : '';
                this.emailError=typeof(error.response.data.errors.email)!=undefined ? error.response.data.errors.email : '';
                this.passwordError=typeof(error.response.data.errors.password)!=undefined ? error.response.data.errors.password : '';
            })
        },
    }
}
</script>