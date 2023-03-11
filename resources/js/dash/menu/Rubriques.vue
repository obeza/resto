<script setup lang="ts">
import { ref, onMounted, defineProps, toRefs, computed, reactive } from 'vue'
import { NCard, NIcon, NTable, numberAnimationProps } from 'naive-ui'
import axiosClient from './../../axios/index'
import { Sortable } from 'sortablejs-vue3'
import {
  EllipsisVertical, Pencil, ClipboardOutline, StatsChartOutline
} from '@vicons/ionicons5'
import store from './../../store/index'
import LayoutAdmin from '../layouts/LayoutAdmin.vue'

interface RubriqueValue {
  id?:any,
  titre: string,
  resto_id: any,
  ordre: number
}
interface TitreAmodifier {
  index?:number | any;
  id?: any
  titre?: string | any;
}

const props = defineProps({
  restoId: String
})
const {restoId}  = toRefs(props)
const restoNom = ref("")

const state = reactive({
  rubriques:[] as RubriqueValue[]
})

// const rubriques = computed(()=>{
//     return state.rubriques
//   })
  
  let rubriques: RubriqueValue[] = []
  const titre = ref()
  const showModalModifier = ref( false )
  const titreAmodifier = ref<TitreAmodifier>({})
  let rubriquesList = []
  
// onMounted(()=> {
//   //console.log('get data')
//   getRubriques();
// })

//async function getRubriques (){
  console.log ( `restoId -> /resto/${restoId?.value}/rubriques` )
  axiosClient.get(`/resto/${restoId?.value}/rubriques`)
    .then(res => {
      console.log( "rubriques loaded : " + JSON.stringify(res.data ))
      state.rubriques = res.data.rubriques
      restoNom.value = store.state.nav.resto = res.data.resto
      
      console.log( "state restoNom : " + JSON.stringify(res.data.resto ))
    })
//}

const addRubrique = async ()=>{
  console.log('addRub : ' + titre.value)
  let order = 0
  if (state.rubriques.length>0) {
    order = state.rubriques[state.rubriques.length-1].ordre + 1
  }
  let rubrique:RubriqueValue = {titre: titre.value, ordre:order, resto_id:restoId?.value}
  
  // sauve via API
  rubrique.id = await saveRubrique(rubrique)

  state.rubriques.push( rubrique )
  titre.value = '' // sinon Object.assign
  console.log('rubriques ' + JSON.stringify(state.rubriques))
  //console.log('rubriques comptuted ' + JSON.stringify(rubriques))
}

const modifyRubrique = async ( id, titre )=>{
  
  axiosClient.put(`/resto/${restoId?.value}/rubriques/${id}`, {titre:titre})
    .then(res => {
      console.log( "rubriques loaded : " + JSON.stringify(res.data ))
      
    })
}

const saveRubrique = (rubrique:RubriqueValue)=> {
  console.log('rubrique : ' + JSON.stringify(rubrique) )
  return new Promise(resolve => {
    axiosClient.post(`/resto/${restoId?.value}/rubriques`, rubrique)
    .then(res => {
      console.log( "rubriqueID res API : " + JSON.stringify(res.data ))
      //resto.value = res.data.resto
      resolve(res.data)
    })
  })
  
}

const saveRubriques = (listRubriquesId )=>{

    axiosClient.post(`/rubriques/liste`, { "liste":listRubriquesId})
    .then(res => {
      console.log( "message : " + JSON.stringify(res.data ))
      //resto.value = res.data.resto
      //resolve(res.data)
    })

}

const dragChange = (event)=> {

  rubriques = rubriques.length ? rubriques : state.rubriques.map((x)=>x)
  let rubrique = rubriques.splice(event.oldIndex,1)[0]
  rubriques.splice(event.newIndex,0, rubrique)
  console.log('event ' + JSON.stringify( rubriques ) )

  let listRubriquesId = ""
  rubriques.map((item)=>{ 
    if (listRubriquesId) listRubriquesId=listRubriquesId+","
    listRubriquesId = listRubriquesId + item.id
    return listRubriquesId
  })
  console.log('listRubriquesId : ' + listRubriquesId )
  saveRubriques(listRubriquesId)
}

const modifierTitre = (id)=>{
  console.log("choose " + id)
  let index = state.rubriques.findIndex(x=>x.id===id)
  console.log("choose index " + index)
  titreAmodifier.value = {
    index: index,
    id:id,
    titre: state.rubriques[index].titre
  }
  console.log('state.rubriques[index].titre ' + titreAmodifier.value.titre)
  showModalModifier.value = true
}

const onPositiveClick = ()=>{
  state.rubriques[titreAmodifier.value.index].titre = titreAmodifier.value.titre
  modifyRubrique( titreAmodifier.value.id, titreAmodifier.value.titre )
  titreAmodifier.value = {}
  showModalModifier.value = false
}

</script>
<template>
  <LayoutAdmin>
    <n-card>
    <n-breadcrumb>
      <n-breadcrumb-item>
        <router-link :to="{ name:'restos' }">
          Restaurants
        </router-link>
      </n-breadcrumb-item>
      <n-breadcrumb-item>
        <router-link :to="{ name:'menu', params: { restoId } }">
          {{ restoNom }}
        </router-link>
      </n-breadcrumb-item>
    </n-breadcrumb>
  </n-card>
  <n-card>
    <h1>Menu du restaurant : {{  restoNom }}</h1>
    <h3>Liste des rubriques</h3>
  </n-card>

  <n-card class="rubrique-list">
  <sortable
    :list="state.rubriques"
    item:key="id"
    tag="div"
    @update="dragChange"
  >
  <h1>Liste des rubriques</h1>
  <template #item="{element, index}">
    
    <div class="draggle" :key="index">
      <div class="spaceIcon">
        <span class="alignCenter"><n-icon size="30"><ellipsis-vertical/></n-icon> {{  element.titre }}</span>
        <span class="alignCenter">
          <n-icon size="24" v-on:click="modifierTitre(element.id)"><pencil/></n-icon>
          <n-icon size="24"><router-link :to="{ name:'articles', params: { rubriqueId:element.id}}"><clipboard-outline/></router-link></n-icon>
        </span>
      </div>
    </div>

  </template>
</sortable>
  </n-card>

  <n-card>
    <div>
      <form v-on:submit.prevent="addRubrique">
        <n-input v-model:value="titre" type="text" placeholder="titre de la rubrique"/>
      </form>
    </div>
    
  </n-card>

  <n-modal
    v-model:show="showModalModifier"
    preset="dialog"
    title="Modifier ce titre"
    positive-text="Confirmer"
    negative-text="Annuler"
    @positive-click="onPositiveClick"
  >
    <n-card>
      <form v-on:submit.prevent="onPositiveClick">
        <n-input v-model:value="titreAmodifier.titre" type="text"/>
      </form>
    </n-card>
  </n-modal>
</LayoutAdmin>
</template>

<style>
.rubrique-list {
  background:#E9ECEF;
}
.draggle {
  border: 1px;
  margin: 2px;
  padding:4px;
  
  background: #fff;
}
.spaceIcon{
  display:flex;
  justify-content: space-between;
  
}
.alignCenter {
  display:flex;
  align-items: center;
}
</style>
