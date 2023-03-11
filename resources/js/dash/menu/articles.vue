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
      <n-breadcrumb-item>
        {{  rubriqueNom }}
      </n-breadcrumb-item>
    </n-breadcrumb>
  </n-card>
  <n-card>
    <h2>Rubrique : {{  rubriqueNom }}</h2>

    <n-space justify="end">  
      <n-button
        type="info"
        @click="router.push({ name:'article-create', params: { rubriqueId }})"
      >Ajouter un article</n-button>
    </n-space>

  </n-card>
  <n-card class="article-list">
    <h3>liste des articles {{ rubriqueId }}</h3>
    <sortable
    :list="state.articles"
    item:key="id"
    tag="div"
    @update="dragChange"
  >
  <h1>Liste des rubriques</h1>
  <template #item="{element, index}">
    
    <div class="draggle" :key="index">
      <div class="spaceIcon">
        <span class="alignCenter"><n-icon size="30"><ellipsis-vertical/></n-icon> {{  element.titre }} -{{  element.id }}</span>
        <span class="alignCenter">
          <n-button quaternary circle>
      <template #icon>
        <n-icon
        @click="router.push({name:'article-update', params:{restoId, rubriqueId, articleId:element.id} })"
        ><create-outline/></n-icon>
      </template>
    </n-button>
        </span>
      </div>
    </div>

  </template>
</sortable>

  </n-card>
  
  
</LayoutAdmin>
</template>


<script setup lang="ts">
import { ref, onMounted, defineProps, toRefs, computed, reactive, } from 'vue'
import { useRouter,useRoute } from 'vue-router';
import axiosClient from './../../axios/index'
import { NButton,NCard, NIcon, NSpace } from 'naive-ui'
import { Sortable } from 'sortablejs-vue3'
import {
  EllipsisVertical, CreateOutline, ClipboardOutline, StatsChartOutline
} from '@vicons/ionicons5'
import store from './../../store/index'
import LayoutAdmin from '../layouts/LayoutAdmin.vue';

//

const router = useRouter();
const route = useRoute()
const rubriqueId = ref(route.params.rubriqueId)
const restoId = ref(route.params.restoId)

interface ArticleValue {
  id?:any,
  titre: string,
  prix: any,
  ordre: number
}

const state = reactive({
  articles:[] as ArticleValue[]
})
let articles: ArticleValue[] = []
const rubriqueNom = ref("")
const restoNom = ref(store.state.nav.resto)

//recupere la liste des articles dans la rubrique selectionnée
console.log(`/rubriques/${rubriqueId.value}/articles`)
axiosClient.get(`/rubriques/${rubriqueId.value}/articles`)
    .then(res => {
      console.log( "msg loaded : " + JSON.stringify(res.data ))
      state.articles = res.data.articles
      rubriqueNom.value = store.state.nav.rubrique = res.data.rubrique
    })



function dragChange(event) {

  articles = articles.length ? articles : state.articles.map((x)=>x)
  let article = articles.splice(event.oldIndex,1)[0]
  articles.splice(event.newIndex,0, article)
  console.log('event ' + JSON.stringify( articles ) )

  let listArticlesId = ""
  articles.map((item)=>{ 
    if (listArticlesId) listArticlesId=listArticlesId+","
    listArticlesId = listArticlesId + item.id
    return listArticlesId
  })
  console.log('listRubriquesId : ' + listArticlesId )
  saveArticles(listArticlesId)
}

function saveArticles(listArticlesId ){
  axiosClient.post(`/articles/liste`, { "liste":listArticlesId})
  .then(res => {
    console.log( "message : " + JSON.stringify(res.data ))
    //resto.value = res.data.resto
    //resolve(res.data)
  })
}


function modifierArticle(articleId){
  //     path: '/menu/:restoId/articles/:rubriqueId/update/:articleId', 
  console.log('route params restoId:' + restoId.value + ' rubriqueId:' + rubriqueId.value + ' articleId:' + articleId)
  router.push({name:'article-update', params:{restoId:restoId.value, rubriqueId:rubriqueId.value, articleId:articleId} });
}

</script>

<style>
.article-list {
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