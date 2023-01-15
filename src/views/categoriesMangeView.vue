<template>
    <button id="buttonaddcategory" data-bs-toggle="modal" class="btn btn-primary mt-5" data-bs-target="#addcategory"><i
            class="bi bi-plus-circle"></i></button>
    <div class="modal fade" id="addcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{
                        isupdate? 'update category': 'add new category'}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" @submit.prevent="isupdate ? updateCategory() : addCategory()">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">category name</label>
                            <input type="text" class="form-control" id="category_name" v-model="category_name">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">{{ isupdate? 'update': 'add' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button style="visibility: hidden;" id="showalert" data-bs-toggle="modal" data-bs-target="#alertmodal"></button>
    <div class="modal fade" id="alertmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">alert</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ alert }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container  mt-5">
        <h1>categories</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">categorie name</th>
                    <th scope="col">created at</th>
                    <th scope="col">operation</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>{{ category.name }}</td>
                    <td>{{ category.created_at }}</td>
                    <td>
                        <button class="btn btn-danger bg-danger col" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" @click="Delete"><i class="bi bi-trash3"></i></button>
                        <button class="btn btn-warning bg-warning col" data-bs-toggle="modal"
                            data-bs-target="#addcategory"><i class="bi bi-pen"
                                @click="editcategory(category.id)"></i></button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">confirm</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        do you really want to delete this category
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"
                                            @click="Deletecategory(category.id)">YES</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import taskService from '@/services/taskService.js';



export default {

    data() {
        return {
            categories: [],
            alert: '',
            category_name: '',
            isupdate: false,
            selectedCategory: null
        }
    },
    methods: {
        updateCategory() {
            let newcategory = {
                name: this.category_name,
            }
            taskService.updateCategory(this.selectedCategory.id, newcategory).then(response => {
                this.alert = response.data;
                document.querySelector('#showalert').click();
                this.getCategories();
            })
        },
        editcategory(id) {
            this.isupdate = true;
            taskService.getCategoryByid(id).then(response => {
                this.selectedCategory = response.data;
                this.category_name = this.selectedCategory.name;
            }).catch(error => {
                this.alert = error;
                document.querySelector('#showalert').click();
                this.getCategories();
            })
        },
        getCategories() {
            taskService.GetCategories().then(response => {
                this.categories = response.data;
            })
        },
        Deletecategory(id) {
            taskService.DeleteCategory(id).then(response => {
                this.alert = response.data;
                document.querySelector('#showalert').click();
                this.getCategories();
            })
        },
        addCategory() {
            let category = {
                name: this.category_name,
            }
            taskService.addCategory(category).then(response => {
                this.alert = 'subtask added succesfully';
                document.querySelector('#showalert').click();
                this.getCategories();
                this.category_name = '';
            })
        }
    },
    created() {
        this.getCategories();
    }
}
</script>