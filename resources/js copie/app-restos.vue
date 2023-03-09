<template>
  <div class="card">
  <div class="card-body">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Restaurants</li>
      </ol>
    </nav>
    <h3 class="user-title">Restaurants</h3>

    <div class="row align-items-start">
      <div class="col">
        <div class="search-box">
          <input v-model="search" class="form-control search-input search" type="text" placeholder="Chercher un utilisateur" aria-label="Search">            
          
        </div>
      </div>
      <div class="col text-right">
        <a class="btn btn-primary" href="/restos/create" role="button">Ajouter</a>
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
          
        </tr>
      </thead>
      <tbody v-if="restos">
        <tr v-for="resto in filterRestos" :key="resto.id">
          <th>{{  resto.nom }}</th>
          
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
    restos: null,
    error: null,
    search: ''
  }
},
mounted(){
  this.getData()
},
computed:{
  filterRestos() {
    return this.restos.filter(item => {
        return item.nom.toUpperCase().includes(this.search.toUpperCase())
      })
  }
},
methods: {
  async getData() {

    this.error = this.post = null
    this.loading = true
    const res = await fetch('http://192.168.1.38:8000/api/resto')
    const finalRes = await res.json()
    this.loading = false
    this.restos = finalRes
    console.log('liste')
    console.log( JSON.stringify( this.restos ))
 
  },
},
}
</script>