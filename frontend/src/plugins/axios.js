import axios from 'axios'

const axiosApi = axios.create({
    baseURL: "http://localhost/api",
})

export default axiosApi