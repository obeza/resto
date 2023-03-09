<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { NCard, NButton, NTable, NIcon, NTooltip } from 'naive-ui'
import axiosClient from './../axios'
import {
  ClipboardOutline, CreateOutline
} from '@vicons/ionicons5'
import { useRouter,useRoute } from 'vue-router';

const loading = ref(false)
const restos = ref([])
const search = ref("")
const router = useRouter();

const filterRestos = computed(() =>{
    return restos.value.filter(item => {
        return item.nom.toUpperCase().includes(search.value.toUpperCase())
      })
  })

loading.value = true
axiosClient.get('/restos')
    .then(res => {
      loading.value = false
      console.log( JSON.stringify(res ))
      restos.value = res.data
      
    })

</script>

<template>
  <n-card title="Restaurants" class="HeaderRubrique">
    <div>
      
    </div>
  </n-card>
  <n-card title="Liste des restaurants">

      <div class="search-box spaceIcon">
          <input v-model="search" class="form-control search-input search" type="text" placeholder="Chercher un restaurant" aria-label="Search">            
          <span class="alignCenter"><n-button
        @click="router.push({ name:'restos-create'})"
        type="info"
      >
      Ajouter un restaurant
      </n-button></span>
      </div>

      <n-table :single-line="false">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Statut</th>
            <th>Abonnement</th>
            <th><div class="textAlignCenter">Actions</div></th>
          </tr>
        </thead>
        <tbody v-if="restos" class="tbody">
          <tr v-for="resto in filterRestos" :key="resto.id">
            <th>{{  resto.nom }}</th>
            <th>{{  resto.actif }}</th>
            <th>{{  resto.dt_abon }}</th>
            <th>
              <div class="textAlignCenter">
                    <n-button
                      tertiary
                      circle
                      type="info"
                      @click="router.push({ name:'restos-update', params: { restoId:resto.id}})"
                    >
                      <n-icon 
                      size="26"
                      ><create-outline/></n-icon>
                    </n-button>
                
              <n-button
                tertiary
                circle
                type="info"
                @click="router.push({ name:'menu', params: { restoId:resto.id}})"
              >
                <n-icon 
                size="26"
                
              
              ><clipboard-outline/></n-icon>
              </n-button>
              </div>
              
              </th>
          </tr>
        </tbody>
      </n-table>

  </n-card>

</template>

<style scoped>
.search-box{
  padding-bottom: 10px;
}
.search-box input {
  width: 300px;
}
.spaceIcon{
  display:flex;
  justify-content: space-between;
  
}
.alignCenter {
  display:flex;
  align-items: center;
}
.textAlignCenter {
  text-align: center;
}
.tbody tr th {
  background-color: #fff;
}

</style>