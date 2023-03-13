<script setup lang="ts">
import { ref, toRefs, PropType } from 'vue'
import { useRouter,useRoute } from 'vue-router';
//import ArticleForm from './components/ArticleForm.vue'
import axiosClient from './../../axios/index'
import { NForm, FormInst, NInput, NSelect, NInputNumber } from 'naive-ui'
import LayoutAdmin from '../layouts/LayoutAdmin.vue';
import store from './../../store/index'

interface Tag {
  id: number
  titre: string
}

const router = useRouter();
// const props = defineProps({
//   rubriqueId: Number
// })
// const {rubriqueId}  = toRefs(props)

const route = useRoute()
const rubriqueId = route.params.rubriqueId
console.log("🚀 ~ file: ArticlesCreate.vue:23 ~ rubriqueId:", rubriqueId)

const restoId = ref(route.params.restoId)
const rubriqueNom = ref(store.state.nav.rubrique)

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
  prix: 0,
  tags:[] as PropType<Tag[]>
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

axiosClient.get( '/tags' ).then( res => {
console.log("🚀 ~ res:", res.data.tags)
  let tags = res.data.tags
  let tagList = <any>[]
  tags.forEach(el => {
    tagList.push({
      label:el.titre,
      value:el.id
    })
  })
  console.log('tagList.value.options ', tagList)
  list.value.options = tagList

}).catch( error => {
  console.log("🚀 ~ error:", error)
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
            const { data } = await axiosClient.post( `/rubriques/${rubriqueId}/articles`, {
              rubrique_id: Number(rubriqueId), //convertir le string en number
              titre: formValue.value.titre,
              resume: formValue.value.resume,
              contenu: formValue.value.contenu,
              prix: formValue.value.prix,
              tags: formValue.value.tags
          });

          console.log( 'message ' + JSON.stringify( data ) );

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
</script>

<template>
  <LayoutAdmin>
    <n-card>
    <n-breadcrumb>
      <n-breadcrumb-item>
        <router-link :to="{ name:'restos' }">
          Restaurant
        </router-link>
      </n-breadcrumb-item>
      <n-breadcrumb-item>
        <router-link :to="{ name:'menu', params: { restoId } }">
          {{ rubriqueNom }}
        </router-link>
      </n-breadcrumb-item>
      <n-breadcrumb-item>
        Articles
      </n-breadcrumb-item>
    </n-breadcrumb>
  </n-card>

  <n-card>
    <h1>Ajouter un article</h1>
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
        <n-button type="info" attr-type="submit">Ajouter</n-button>
  </n-form>
  </n-card>
</LayoutAdmin>
</template>