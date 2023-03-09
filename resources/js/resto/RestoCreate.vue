<script setup lang="ts">
import { ref } from 'vue';
import axiosClient from './../axios'
import { NButton, NSpace, NForm, FormInst, NCard } from 'naive-ui'
import RestoForm from './RestoForm.vue'

//const baseurl = `${import.meta.env.VITE_URL_API}`;

const currentDate = new Date()
const timestamp = currentDate.getTime()

const formValue= ref({
  nom: '',
  tel: '',
  email: '',
  adresse: '',
  commentaire: '',
  dt_abon: ref(1183135260000),
  actif: ref(true)
})

const formRef = ref<FormInst | null>(null);
// const getToken = async() => {
//   await axios.get( baseurl + "/sanctum/csrf-cookie");
// };

const rules = ref({
  nom: {
    required: true,
    message: "Entrez le nom",
    trigger: ['input']
  },
  tel: {
    required: true,
    message: "Entrez le tel",
    trigger: ['input']
  },
  email: {
    required: false
  },
  adresse: {
    required: false
  },
  commentaire: {
    required: false
  },
  dt_abon: {
    required: false
  },
  actif: {
    required: false
  },

})

const handleAdd = async() => {
  console.log('formValue')
  console.log ( 'formValue :' + JSON.stringify(formValue.value))
  formRef.value?.validate(async (errors) => {
    if (!errors){
      //await getToken();

      try {
        const { data } = await axiosClient.post( '/restos' , formValue.value );
        console.log('data get')
        console.log( JSON.stringify( data ) );

      } catch(error) {
        console.log('error ....')
        console.log( JSON.stringify(error.response.data))
      }

    } else {
      console.log('errors formRef ...')
    }
  })
  
}

</script>

<template>
  <n-card title="Ajouter un restaurant" class="HeaderRubrique">
    <div>
      <router-link to="/restos">Restaurants</router-link>
      / Ajouter un restaurant
    </div>
  </n-card>
  <n-card>
    <n-space>
      <n-form 
        ref="formRef"
        @submit.prevent="handleAdd"
        :model="formValue"
        :rules="rules"
      >
        <RestoForm
          v-model:nom="formValue.nom"
          v-model:tel="formValue.tel"
          v-model:email="formValue.email"
          v-model:adresse="formValue.adresse"
          v-model:commentaire="formValue.commentaire"
          v-model:dt_abon="formValue.dt_abon"
          v-model:actif="formValue.actif"
        />
        <n-button type="info" attr-type="submit">Ajouter</n-button>
        
      </n-form>
    </n-space>
  </n-card>
  
  <pre>{{  JSON.stringify(formValue) }}</pre>
  
</template>