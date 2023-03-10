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
        <!-- path: '/menu/:restoId/articles/:rubriqueId',  -->
        <router-link :to="{ name:'articles', params: { restoId, rubriqueId } }">
          {{ rubriqueNom }}
        </router-link>
      </n-breadcrumb-item>
    </n-breadcrumb>
  </n-card>
  <n-card>
    <h1>Modifier l'article {{  formValue.titre }}</h1>
  </n-card>
  <n-card>
  <n-form 
    ref="formRef"
    @submit.prevent="handleForm"
    :model="formValue"
    :rules="rules"
  >
    <n-form-item label="Titre" path="titre">
          <n-input
            v-model:value="formValue.titre"
            type="text"
          />
        </n-form-item>
      
        <n-form-item label="Resume" path="resume">
          <n-input 
            v-model:value="formValue.resume" 
            type="text"
            maxlength="255"
          />
        </n-form-item>
         
        <n-form-item label="Contenu" path="contenu">
          <n-input 
            v-model:value="formValue.contenu" 
            type="textarea"
            maxlength="500"
          />
        </n-form-item>

        <n-upload
          :action="`/api/articles/upload/${articleId}`"
          :headers="{
            'Authorization': `Bearer ${store.state.user.token}`
          }"
          list-type="image-card"
          :max="1"
          name="picture"
          :default-file-list="formValue.picture"
          :on-remove="supprimerPhoto"
        >
        Envoyer une photo
        </n-upload>
        <n-divider/>

        <n-form-item label="Prix" path="prix">
          <n-input-number 
            v-model:value="formValue.prix"
            clearable
            :precision="2"
          />
        </n-form-item>

        <n-form-item label="Tags" path="tags">
          <n-select 
            v-model:value="formValue.tags"
            multiple
            :options="list.options"
          />
        </n-form-item>
        <n-button type="info" attr-type="submit">Modifier</n-button>
  </n-form>
  </n-card>
</LayoutAdmin>
</template>

<script setup lang="ts">
import { ref, toRefs, PropType } from 'vue'
import { useRouter,useRoute } from 'vue-router';
//import ArticleForm from './components/ArticleForm.vue'
import axiosClient from './../axios'
import { NForm, FormInst, NInput, NSelect, NInputNumber, NUpload, NDivider } from 'naive-ui'
import store from './../store'
import type { UploadFileInfo } from 'naive-ui';

import LayoutAdmin from '../layouts/LayoutAdmin.vue';

interface Tag {
  id: number
  titre: string
}
const BaseUrl = store.state.BaseUrl
const router = useRouter();
// const props = defineProps({
//   rubriqueId: Number
// })
// const {rubriqueId}  = toRefs(props)

const route = useRoute()
const rubriqueId = route.params.rubriqueId
const restoId = route.params.restoId
const articleId = route.params.articleId

const rubriqueNom = ref(store.state.nav.rubrique)
const restoNom = ref(store.state.nav.resto)

const rules = ref({
  titre: {
    required: true,
    message: 'Entrez un titre',
    trigger: ['input']
  }
}) 
const formRef = ref<FormInst | null>(null);

const formValue= ref({
  titre: '',
  resume: '',
  contenu: '',
  picture: ref<UploadFileInfo[]>([]),
  prix: 0,
  tags: []
})
const list = ref({
  options: [
    {
      label: 'Cuisson',
      value: 1
    },
    {
      label: 'Sauce',
      value: 2
    }
    
  ]
})

//const baseUrlAction = ref('/api/articles/8/upload')

// get l'article data
// console.log( 'reubriqueId ' + JSON.stringify(rubriqueId ))
console.log(`get -> /rubriques/${rubriqueId}/articles/${articleId}`)
const baseUrl = `/rubriques/${rubriqueId}/articles/${articleId}`
const baseUrlAction = ref(baseUrl)
axiosClient.get( baseUrl + '/edit' )
    .then(res => {
      console.log( "data article loaded : " + JSON.stringify(res.data ))
      //state.articles = res.data.articles
      let article = res.data
      formValue.value.titre = article.titre
      formValue.value.resume = article.resume
      formValue.value.contenu = article.contenu
      if (article.picture) {
         formValue.value.picture.push({ 
        id: '1',
        name: 'photo',
        status: 'finished',
        url: `${BaseUrl}/storage/app/${article.picture}`
      })
    }
      console.log(`${BaseUrl}/storage/app/${article.picture}`)
        formValue.value.prix = Number(article.prix)
      formValue.value.tags = article.tags
    })

function handleForm (){
  console.group("rubId " + rubriqueId)
  console.log('pass handleForm ' + JSON.stringify( {
            rubrique_id: Number(rubriqueId),
            titre: formValue.value.titre,
            resume: formValue.value.resume,
            contenu: formValue.value.contenu,
            prix: formValue.value.prix,
            tags: formValue.value.tags
          } ))

  formRef.value?.validate(async (errors) => {
    if (!errors ){
      try {
        console.log('picture ' + formValue.value.picture)
            const { data } = await axiosClient.put( baseUrl, {
              titre: formValue.value.titre,
              resume: formValue.value.resume,
              contenu: formValue.value.contenu,
              // picture: formValue.value.picture[0],
              prix: formValue.value.prix,
              tags: formValue.value.tags
          });

          console.log( 'message update' + JSON.stringify( data ) );


          router.push({name:'articles', params:{rubriqueId:rubriqueId} });
      } catch (errorCatch){
            console.log('error '+errorCatch)
            errorCatch.value = true
      }
    } else {
      console.log('form invalid')
    }
  })
}

function supprimerPhoto(){
  console.log('remove ' )
  axiosClient.post( `/articles/upload/${articleId}/remove` )
  .then( res =>{
    console.log('remove ' + res)
  })
}

</script>

