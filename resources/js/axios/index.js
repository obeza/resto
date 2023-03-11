import axios from "axios"
import store from "../store/index"
import useAuthStore from '../store/auth'

//store.state.BaseUrl = 'http://192.168.1.38:5173'

//const authStore = useAuthStore()


const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_URL_API}/api`
})

axiosClient.interceptors.request.use(config => {
  console.log('axiosclient')
  const authStoreBearer = useAuthStore()
  console.log('authStoreBearer')
  console.log('authStore.authUser.token ' + authStoreBearer.user)
  if (authStoreBearer.user) {
    config.headers.Authorization = `Bearer ${authStoreBearer.authUser.token}`;
  }
  
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

axiosClient.interceptors.response.use((response) => {
  // Do something with response data
  //loader.hide(); //hiding loader on when receive response
  return response;
}, (error) => {
   // check for errorHandle config
  //  if (error.config.hasOwnProperty("errorHandle") &&
  //           error.config.errorHandle === false) {
  //     loader.hide(); //hiding loader on error
  //     return Promise.reject(error);
  //  }
   // Do something with response error
   if (error.response.status) {
    const authStore = useAuthStore()
          //  loader.hide(); //hiding loader on error
//Handling different error status using Switch caase               
          switch (error.response.status) {
              // case 400:
              //   this.$swal(error.response.data.message, {
              //     closeOnClickOutside: false
              //   }); //showing Swal Alert
              //   break;
              case 401:
                //logout user
                console.log('erreur 401')
                authStore.resetUser()
                window.location.href = "/dash/login";
                break;
              // case 403:
              //   this.$swal(error.response.data.message, {
              //     closeOnClickOutside: false
              //   }); //showing Swal Alert
              //   break;
              // case 404:
              //   this.$swal(error.response.data.message, {
              //     closeOnClickOutside: false
              //   }); //showing Swal Alert
              //   break;
              // case 500:
              //   this.$swal(error.response.data.message, {
              //     closeOnClickOutside: false
              //   }); //showing Swal Alert
              // }
          }
        }
});

export default axiosClient;