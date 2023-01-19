import axios from "axios";
import { useAuthStore } from "@/store/auth.store";

export default {
    async login(user) {
        const State = useAuthStore();
        const attempt = await axios.post('http://localhost:8000/api/users/logIn', user);
        console.log(attempt);
        if (attempt.status = 200) {
            State.login(attempt.data.token, attempt.data.user);
            /*Promise.resolve(attempt.data);
            return attempt.data;*/
        } else {
            State.logout();
            //  Promise.reject('something went wrong');
        }
    }
}