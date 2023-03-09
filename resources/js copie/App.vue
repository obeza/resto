<template>
    <div class="card">
    <div class="card-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
        </ol>
      </nav>
      <h3 class="user-title">Utilisateurs</h3>

      <div class="row align-items-start">
        <div class="col">
          <div class="search-box">
            <input v-model="search" class="form-control search-input search" type="text" placeholder="Chercher un utilisateur" aria-label="Search">            
            
          </div>
        </div>
        <div class="col text-right">
          <a class="btn btn-primary" href="/users/create" role="button">Ajouter</a>
        </div>
      </div>

    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
      <table class="table">
        <thead class="table-dark">
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col" class="d-none d-sm-block">Email</th>
            <th scope="col" class="d-none d-sm-block">Role</th>
          </tr>
        </thead>
        <tbody v-if="users">
          <tr v-for="user in filterUsers" :key="user.id">
            <th>{{  user.nom }}</th>
            <th>{{  user.prenom }}</th>
            <th class="d-none d-sm-block">{{ user.email }}</th>
            <th class="d-none d-sm-block">{{ user.role }}</th>
          </tr>
        </tbody>
      </table>
      </div>
      <div class="loading" v-if="loading">Loading...</div>
      <div class="error" v-if="error">Loading...</div>
        
    </div>
  </div>



</template>

<script>
import { onMounted } from '@vue/runtime-core'
export default{
  data() {
    return {
      loading: false,
      users: null,
      error: null,
      search: ''
    }
  },
  mounted(){
    this.getData()
  },
  computed:{
    filterUsers() {
      return this.users.filter( 
        (entry ) => this.users.length ? Object.keys(this.users[0])
        .some( key => ('' + entry[key]).toLowerCase().includes(this.search))
        : true
      )
    }
  },
  methods: {
    async getData() {

      this.error = this.post = null
      this.loading = true
      const res = await fetch('http://192.168.1.38:8000/api/user')
      const finalRes = await res.json()
      this.loading = false
      this.users = finalRes
      console.log( JSON.stringify( this.users ))
   
    },
  },
}
</script>