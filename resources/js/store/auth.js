import { defineStore } from 'pinia'
//import axios from 'axios'

const useAuthStore = defineStore('auth',{
  state: ()=>({
    authUser: null,
    isLoggedIn: false
  }),
  getters: {
    user:(state)=> state.authUser,
  },
  actions: {
    setUser(data){
      this.authUser = data
      localStorage.setItem('user', JSON.stringify(data))
      this.isLoggedIn = true
    },
    checkLocalStore(){
      this.authUser = JSON.parse( localStorage.getItem('user') )
      this.isLoggedIn = this.authUser ? true : false
    },
    resetUser(){
      this.authUser = null
      this.isLoggedIn = false
      localStorage.removeItem('user')
    }
  }
})

export default useAuthStore;