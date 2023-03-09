import axios from "axios"
import store from "./../store"

const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_URL_API}/api`
})

axiosClient.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${store.state.user.token}`;

  if (
    config.method == 'post' || 
    config.method == 'put' || 
    config.method == 'delete'
  )  {
  return setCSRFToken()
      .then(response => config);
  }

  return config;
})

// A function that calls '/api/csrf-cookie' to set the CSRF cookies. The 
// default is 'sanctum/csrf-cookie' but you can configure it to be anything.
const setCSRFToken = () => {
  return axiosClient.get(`${import.meta.env.VITE_URL_API}/sanctum/csrf-cookie`); // resolves to '/api/csrf-cookie'.
}

export default axiosClient;