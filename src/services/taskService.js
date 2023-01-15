import axios from "axios";

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api/tasks/',
    withCredentials: false,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
})

export default {
    getTasks(search) {
        return apiClient.get(search);
    },
    getTaskswithsubtasks(page) {
        return apiClient.get('/subtasks?page=' + page);
    },
    createTask(task) {
        return axios.post('http://localhost:8000/api/tasks/', task);
    },
    deleteTask(id) {
        return axios.delete('http://localhost:8000/api/tasks/' + id);
    },
    updateTask(id, newStatus) {
        return axios.put('http://localhost:8000/api/tasks/updatestatus/' + id, newStatus);
    },
    createSubTask(subtask, id_task) {
        return axios.post('http://localhost:8000/api/tasks/subtasks/' + id_task, subtask);
    },
    makeDone(id) {
        return axios.put('http://localhost:8000/api/tasks/subtasks/done/' + id);
    },
    DeleteSubTask(id) {
        return axios.delete('http://localhost:8000/api/tasks/subtasks/' + id);
    },
    getTaskWithId(id) {
        return axios.get('http://localhost:8000/api/tasks/' + id);
    },
    updateTaskInfo(id, task) {
        return axios.put('http://localhost:8000/api/tasks/' + id, task);
    },
    searchTask(search) {
        return apiClient.get(`/search?search=${ search ? search : ''}`);
    },
    UpdateSubtask(id, subtask) {
        return axios.put('http://localhost:8000/api/tasks/subtasks/' + id, subtask);
    },
    GetCategories() {
        return axios.get('http://localhost:8000/api/categories/');
    },
    addCategory(category) {
        return axios.post('http://localhost:8000/api/categories/', category);
    },
    DeleteCategory(id) {
        return axios.delete('http://localhost:8000/api/categories/' + id);
    },
    getCategoryByid(id) {
        return axios.get('http://localhost:8000/api/categories/' + id);
    },
    updateCategory(id, category) {
        return axios.put('http://localhost:8000/api/categories/' + id, category);
    },
    createrelation(newaddcategory) {
        return axios.post('http://localhost:8000/api/tasks/addcategory', newaddcategory);
    }
}