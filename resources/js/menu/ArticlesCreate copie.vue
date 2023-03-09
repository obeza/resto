<script setup lang="ts">
import { ref, toRefs, PropType } from 'vue'
import { useRouter } from 'vue-router';
import ArticleForm from './components/ArticleForm.vue'
import axiosClient from './../axios.js'
import { NForm, FormInst } from 'naive-ui'

interface Tag {
  id: number
  titre: string
}

const router = useRouter();
const props = defineProps({
  rubriqueId: Number
})
const {rubriqueId}  = toRefs(props)

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

function handleForm (){
  console.log('pass handleForm ' + JSON.stringify( {
            rubrique_id: Number( rubriqueId._object.rubriqueId),
            titre: formValue.value.titre,
            resume: formValue.value.resume,
            contenu: formValue.value.contenu,
            prix: formValue.value.prix,
            tags: formValue.value.tags
          } ))

  formRef.value?.validate(async (errors) => {
    if (!errors){
      try {
            const { data } = await axiosClient.post( '/articles' , {
              rubrique_id: Number( rubriqueId._object.rubriqueId), //convertir le string en number
              titre: formValue.value.titre,
              resume: formValue.value.resume,
              contenu: formValue.value.contenu,
              prix: formValue.value.prix,
              tags: formValue.value.tags
          });

          console.log( 'login OK ' + JSON.stringify( data ) );


          //router.push('/');
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
  <n-card>
    <h1>Ajouter un article -{{  rubriqueId }}</h1>
  </n-card>
  <n-card>
  <n-form 
    ref="formRef"
    @submit.prevent="handleForm"
    :model="formValue"
    :rules="rules"
  >
    <ArticleForm
      @handleForm="handleForm"
      actionNom="Ajouter--"
      v-model:titre="formValue.titre"
      v-model:resume="formValue.resume"
      v-model:contenu="formValue.contenu"
      v-model:prix="formValue.prix"
    />
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
</template>