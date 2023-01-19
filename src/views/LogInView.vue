<template>
    <!--log in form email password-->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Log In</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <label for="email" class="float-start">Email</label>
                                <input type="email" class="form-control" id="email" v-model="email">
                                <!-- <p class="text-danger" v-if="emailError">{{ emailError[0] }}</p> -->
                            </div>
                            <div class="form-group">
                                <label for="password" class="float-start">Password</label>
                                <input type="password" class="form-control" id="password" v-model="password">
                                <!-- <p class="text-danger" v-if="passwordError">{{ passwordError[0] }}</p> -->
                            </div>
                            <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <h3>you dont have an account yet <router-link to="signUp">create an account</router-link></h3>
        </div>
    </div>
</template>
<script>
import authService  from '@/services/authService';
import { useAuthStore } from '@/store/auth.store';
export default {
    data(){
        return{
            email:'',
            password:'',
            error:'',
        }
    },
    setup(){
        const store=useAuthStore();
        return {
            store,
        }
    },
    methods:{

         login(){
            let response= authService.login({email:email.value,password:password.value});
            if(response){
                this.$router.push('/');
            }else{
                this.error='smthng went wrong';
            }
        }
    }
   
}
</script>